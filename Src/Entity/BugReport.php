<?php declare( strict_types=1 );


namespace App\Entity;


class BugReport extends Entity
{
    private $id;
    private $report_type;
    private $email;
    private $link;
    private $message;
    private $created_at;

    public function getId (): int
    {
        return (int) $this->id;
    }

    public function setReportType(string $reportType): BugReport
    {
       $this->report_type = $reportType;
       return $this;
    }

    public function getReportType(): string
    {
        return $this->report_type;
    }

    public function getEmail (): string
    {
        return $this->email;
    }

    public function setEmail (string $email): BugReport
    {
        $this->email = $email;
        return $this;
    }

    public function getLink (): ?string
    {
        return $this->link;
    }

    public function setLink (?string $link): BugReport
    {
        $this->link = $link;
        return $this;
    }

    public function getMessage (): string
    {
        return $this->message;
    }

    public function setMessage (string $message): BugReport
    {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function toArray (): array
    {
        return [
            'report_type' => $this->getReportType(),
            'email' => $this->getEmail(),
            'message' => $this->getMessage(),
            'link' => $this->getLink(),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}