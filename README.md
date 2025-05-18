# Product Reminder Module for Magento 2

## Overview
This module allows customers to set product reminder notifications via REST API. It includes admin configurations, email notifications, and cron/observer logic.

## Features
- Admin configuration (enable/disable, sender email, default message)
- Custom database table
- REST APIs for creating, listing, and deleting reminders
- Cron job to send emails on reminder date
- Observer to clean up reminders when product is deleted
- ACL-protected API access (optional)
- Upcoming reminder notifications (1 week before)

## Installation Instructions
1. Copy the module to `app/code/`
2. Run the following commands:

```bash
php bin/magento module:enable Rai_ProductReminder
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
