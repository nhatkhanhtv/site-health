<?php

namespace App\Notifications;

use App\Models\ServerCheck;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\SlackMessage;

class AlertServerCheckNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $serverCheckInfo;
    /**
     * Create a new notification instance.
     */
    public function __construct(ServerCheck $serverCheckInfo)
    {
        $this->serverCheckInfo = $serverCheckInfo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        $serverCheckInfo = $this->serverCheckInfo;
        $serverCheckInfo->load('serverInfo');
        $slackMessage = (new SlackMessage)->headerBlock('FREE DISK LOW!!!');       
            $slackMessage = $slackMessage->sectionBlock(function (SectionBlock $sectionBlock) use ($serverCheckInfo) {
                
                $sectionBlock->text("Server: *".$serverCheckInfo->serverInfo->name."*!");                
            })
            ->sectionBlock(function (SectionBlock $sectionBlock) use ($serverCheckInfo) {
                $sectionBlock->text("IP: *".$serverCheckInfo->serverInfo->ip."*!");                
            })
            // ->contextBlock(function (ContextBlock $block) use ($serverCheckInfo) {
            //     $block->text("Domain: *".$serverCheckInfo->siteInfo->site_name."*");                
            // })
            ->contextBlock(function(ContextBlock $block ) use ($serverCheckInfo) {
                $block->text("At: *". $serverCheckInfo->created_at."*");
            })
            ->sectionBlock(function (SectionBlock $sectionBlock)  {
                $sectionBlock->text("Disk:");
                
            });
            $diskMessage = explode("<br>", $serverCheckInfo->disk);
            foreach($diskMessage as $message) {
                $slackMessage = $slackMessage->contextBlock(function(ContextBlock $block) use($message) {
                    $block->text($message);
                });
            }
        return $slackMessage;
    }
}
