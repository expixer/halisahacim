<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class ReservationRequestNotification extends Notification {
  use Queueable;

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array {
    return [FcmChannel::class];
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toFcm($notifiable): FcmMessage
  {
    return (new FcmMessage(notification: new FcmNotification(
      title: 'Account Activated',
      body: 'Your account has been activated.',
      image: 'http://example.com/url-to-image-here.png'
    )))
      ->data(['data1' => 'value', 'data2' => 'value2'])
      ->custom([
        'android' => [
          'notification' => [
            'color' => '#0A0A0A',
            'sound' => 'default',
          ],
          'fcm_options' => [
            'analytics_label' => 'analytics',
          ],
        ],
        'apns' => [
          'payload' => [
            'aps' => [
              'sound' => 'default'
            ],
          ],
          'fcm_options' => [
            'analytics_label' => 'analytics',
          ],
        ],
      ]);
  }}
