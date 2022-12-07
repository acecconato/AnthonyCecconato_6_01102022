<?php

namespace App\Mailer;

use Psr\Container\ContainerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailSender implements EmailSenderInterface
{
    /** @var \ArrayObject<string, mixed> */
    private \ArrayObject $options;

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly ContainerInterface $container,
        private string $sender
    ) {
        $this->options = new \ArrayObject();
    }

    public function with(array $options): EmailSenderInterface
    {
        foreach ($options as $optionName => $optionValue) {
            if ($this->options->offsetExists($optionName)) {
                throw new \InvalidArgumentException("Option $optionName is already defined");
            }

            $this->options->offsetSet($optionName, $optionValue);
        }

        return $this;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function send(string $className): void
    {
        if (!$this->container->has($className)) {
            throw new \InvalidArgumentException("$className must implement EmailDefaultInterface");
        }

        /** @var \App\Mailer\Email\EmailDefaultInterface $email */
        $email = $this->container->get($className);

        $resolver = new OptionsResolver();
        $email->configureOptions($resolver);
        $options = $resolver->resolve($this->options->getArrayCopy());

        $templatedEmail = (new TemplatedEmail())->from(new Address($this->sender, 'Snowtricks'));

        $email->build($templatedEmail, $options);

        $this->mailer->send($templatedEmail);
    }

    public function setSender(string $sender): EmailSenderInterface
    {
        $this->sender = $sender;

        return $this;
    }
}
