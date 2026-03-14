<?php

namespace App\Notifications;

use App\Models\SiteUptime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ActionsBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\SlackMessage;

class AlertSiteDownNotification extends Notification 
implements ShouldQueue
{
    use Queueable;

    public $downsites;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $downsites)
    {
        
        $this->downsites = $downsites;
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
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }

    public function toSlack(object $notifiable): SlackMessage
    {
        $slackMessage = (new SlackMessage)->headerBlock('DOWN SITE ALERT!!!');
        foreach($this->downsites as $siteUptime) {
            $slackMessage = $slackMessage
                ->sectionBlock(function (SectionBlock $sectionBlock) use ($siteUptime) {
                    $sectionBlock->text("Domain: *".$siteUptime->siteInfo->site_name."* is down!");                
                })
                // ->contextBlock(function (ContextBlock $block) use ($siteUptime) {
                //     $block->text("Domain: *".$siteUptime->siteInfo->site_name."*");                
                // })
                ->contextBlock(function(ContextBlock $block ) use ($siteUptime) {
                    $block->text("At: *". $siteUptime->checked_at."*");
                })
                ->contextBlock(function(ContextBlock $block ) use ($siteUptime) {
                    $block->text("Error: *". $siteUptime->error."*");
                });
        }
        return $slackMessage;

        // return (new SlackMessage)
        //     // ->text("Domain ".$siteUptime->siteInfo->site_name ." is down!")
        //     ->headerBlock("Domain ".$siteUptime->siteInfo->site_name ." is down!")
        //     ->contextBlock(function (ContextBlock $block) use ($siteUptime) {
        //         $block->text("Domain: *".$siteUptime->siteInfo->site_name."*");                
        //     })
        //     ->contextBlock(function(ContextBlock $block ) use ($siteUptime) {
        //         $block->text("At: *". $siteUptime->checked_at."*");
        //     })
        //     ->contextBlock(function(ContextBlock $block ) use ($siteUptime) {
        //         $block->text("Error: *". $siteUptime->error."*");
        //     });
            // ->text("Domain: ".$siteUptime->siteInfo->site_name)
            // ->text("At: ". $siteUptime->checked_at)
            // ->text("Error: ".$siteUptime->error);
            // ->sectionBlock(function (SectionBlock $block) {
            //     $block->text('Site Down.');
            // })
            // ->actionsBlock(function (ActionsBlock $block) {
            //     // ID defaults to "button_acknowledge_invoice"...
            //     $block->button('Acknowledge Invoice')->primary();
    
            //     // Manually configure the ID...
            //     $block->button('Deny')->danger()->id('deny_invoice');
            // });
}
}
