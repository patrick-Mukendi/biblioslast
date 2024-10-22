<?php

namespace App\Webhook;

use Symfony\Component\HttpFoundation\ChainRequestMatcher;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcher\IsJsonRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\MethodRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\RemoteEvent\RemoteEvent;
use Symfony\Component\Webhook\Client\AbstractRequestParser;
use Symfony\Component\Webhook\Exception\RejectWebhookException;

final class GithubRequestParser extends AbstractRequestParser
{
    protected function getRequestMatcher(): RequestMatcherInterface
    {
        return new ChainRequestMatcher([
            new MethodRequestMatcher(Request::METHOD_POST),
            new IsJsonRequestMatcher(),
        ]);
    }

    protected function doParse(
        Request $request,
        #[\SensitiveParameter] string $secret
    ): ?RemoteEvent {
        $this->validateSignature(
            headers: $request->headers,
            body: $request->getContent(),
            secret: $secret
        );

        return new RemoteEvent(
            name: $request->headers->get('X-GitHub-Event'),
            id: $request->headers->get('X-GitHub-Hook-ID'),
            payload: $request->getPayload()->all()
        );
    }

    private function validateSignature(
        HeaderBag $headers, string $body,
        #[\SensitiveParameter] string $secret
    ): void {
        $signature = hash_hmac('sha256', $body, $secret);

        if (!hash_equals($signature, $headers->get('X-Hub-Signature-256'))) {
            throw new RejectWebhookException(406, 'Invalid signature.');
        }
    }
}
