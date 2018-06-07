<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class BookWasReleased extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }

    public function toTwitter($notifiable)
    {
        //return new TwitterStatusUpdate('This is a live tweet from my @fwdays talk about Laravel notifications ✌️');
        return (new TwitterStatusUpdate('This is a live tweet from my talk about Laravel notifications ✌️'))->withImage('https://christoph-rumpel.com/images/book/book_v1.png');
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('News', ':robot_face:')
            ->to('#general')
            ->content('Hey, Christoph just released his chatbot book!')
            ->attachment(function ($attachment) {
                $attachment->title('Book')
                    ->image('https://christoph-rumpel.com/images/book/book_v1.png')
                    ->fields([
                        'Title' => 'Build Chatbots with PHP',
                        'Price' => '€39,90',
                    ]);
            });
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Book Released')
                    ->line('Christoph just released his chatbot book 🎉')
                    ->action('Read More', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'I just released my new ebook',
            'actionUrl' => 'https://christoph-rumpel.com'
        ];
    }
}
