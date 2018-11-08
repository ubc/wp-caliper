<?php

namespace IMSGlobal\Caliper\entities;

class Message extends DigitalResource {
    /** @var string|null */
    private $body;
    /** @var Message|null */
    private $replyTo;
    /** @var DigitalResource[]|null */
    private $attachments;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new EntityType(EntityType::MESSAGE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'body' => $this->getBody(),
            'replyTo' => $this->getReplyTo(),
            'attachments' => $this->getAttachments(),
        ]));
    }

    /** @return null|string */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param null|string $body
     * @throws \InvalidArgumentException string required
     * @return $this|Message
     */
    public function setBody($body) {
        if (is_null($body) || is_string($body)) {
            $this->body = $body;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': string expected');
    }

    /** @return Message|null */
    public function getReplyTo() {
        return $this->replyTo;
    }

    /**
     * @param Message|null $replyTo
     * @throws \InvalidArgumentException Message required
     * @return $this|Message
     */
    public function setReplyTo($replyTo) {
        if (!is_null($replyTo) && !($replyTo instanceof Message)) {
            throw new \InvalidArgumentException(__METHOD__ . ': Message expected');
        }

        $this->replyTo = $replyTo;
        return $this;
    }

    /** @return DigitalResource[]|null */
    public function getAttachments() {
        return $this->attachments;
    }

    /**
     * @param DigitalResource|DigitalResource[]|null $attachments
     * @throws \InvalidArgumentException array of DigitalResource required
     * @return $this|Message
     */
    public function setAttachments($attachments) {
        if (!is_null($attachments)) {
            if (!is_array($attachments)) {
                $attachments = [$attachments];
            }

            foreach ($attachments as $attachment) {
                if (!($attachment instanceof DigitalResource)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of DigitalResource expected');
                }
            }
        }

        $this->attachments = $attachments;
        return $this;
    }
}
