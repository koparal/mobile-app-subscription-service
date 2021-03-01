Mobile Application Subscription API Service.
## Installation

```bash
git clone https://github.com/koparal/mobile-app-subscription-service.git
```

## Composer Install

```bash
composer install
```


## Edit .env 

```bash
QUEUE_DRIVER=database
QUEUE_CONNECTION=database
```

## Migration 
```bash
php artisan migrate
```

## DB Seed For Sample Data (Optional)
```bash
php artisan db:seed
```

## 1. API

* Register

    Endpoint : /api/register
    
    Body : form-data
    
    Params :
    
        uid
        app_id
        language
        operating_system
        username (optional)
        password (optional)

* Purchase

    Endpoint : /api/subscription/purchase
    
    Body : form-data
    
    Params :
    
        client_token
        receipt

* Check Subscription

    Endpoint : /api/subscription/check
    
    Body : form-data
    
    Params :
    
        client_token

## 2. Worker
#### Manuel Using

```bash
// Run queue
php artisan queue:work

// Run the command for update expired subscriptions
php artisan update:expired-subscriptions

// Run the command for retry failed callback events
php artisan retry:failed-callback-events
```

#### With Supervisor to Scheduling
```bash

// add to config file below command.
php artisan schedule:run
```

## 3. Callback
    
If the subscription status changes; 

Sends the event info via POST to the 3rd party url assigned to the application.

If the 3rd party endpoint respond 500, it saves the event info in the failed_callback_events table. And then it sends the event info again to the relevant endpoint.

```bash
php artisan retry: failed-callback-events
```

With the command, you can resend the failed events.
