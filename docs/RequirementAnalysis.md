# Requirement Analysis

## Flojics Technical Assessment

---

# Project Overview

This project extends an existing Help Desk SaaS platform by introducing a **Ticket Escalation** feature.

The existing system already contains the following entities:

* Users
* Customers
* Agents
* Tickets

The new feature allows support agents to escalate tickets whenever additional attention is required.

When a ticket is escalated, the system:

* Changes the ticket status to **Escalated**
* Records the escalation date and time
* Sends notifications through multiple channels
* Automatically retries failed notifications
* Tracks every notification attempt

The implementation focuses on clean architecture, maintainability, scalability, and production-ready design.

---

# Existing Help Desk System

The assessment assumes an existing Help Desk application with the following workflow:

1. Customers create support tickets.
2. Tickets are assigned to support agents.
3. Agents manage tickets during their lifecycle.
4. Tickets move through different statuses:

* Open
* In Progress
* Resolved
* Closed

This assessment introduces an additional workflow:

```
Open
      │
      ▼
In Progress
      │
      ▼
Escalated
      │
      ▼
Resolved
      │
      ▼
Closed
```

---

# Questions for the Product Owner

The following questions would normally be discussed before implementation.

### Ticket Escalation

* Can an already escalated ticket be escalated again?
* Is there any maximum number of escalations?
* Should an escalation reason be stored?
* Should escalations be visible in an audit log?

### Notification Channels

* Should all channels always be used?
* Can administrators enable or disable channels?
* Should customers choose their preferred notification channels?

### Retry Strategy

* Should retry delays be configurable?
* Should retries use exponential backoff?
* Should administrators manually retry failed notifications?

### Slack

* Should Slack notifications go to one channel or multiple channels?
* Should each department have its own Slack webhook?

### Email

* Should different email templates exist based on ticket priority?
* Should notification emails include ticket history?

---

# Assumptions

Since answers were not provided, the following assumptions were made.

* A ticket can only be escalated once.
* Every escalation sends notifications through Email and Slack.
* Notifications are processed asynchronously using Laravel Queues.
* Failed notifications are automatically retried up to three times.
* Every retry attempt is stored in the database.
* Ticket escalation does not require additional approval.
* Notification failures do not roll back the ticket escalation.
* The Help Desk system already contains Users, Customers, Agents, and Tickets.

---

# Functional Requirements

## Ticket Escalation

When an escalation request is received:

* Validate the ticket exists.
* Prevent duplicate escalations.
* Change ticket status to **Escalated**.
* Save the escalation timestamp.
* Create notification records.
* Dispatch notification jobs.

---

## Notifications

Supported channels:

* Email
* Slack

The notification system is designed to support additional channels without modifying existing business logic.

Examples:

* WhatsApp
* SMS
* Microsoft Teams
* Push Notifications

---

## Retry Mechanism

If notification delivery fails:

* Retry automatically.
* Maximum retry attempts: **3**
* Every attempt is stored.
* Final notification status becomes **Failed** after retries are exhausted.

---

# Non-Functional Requirements

The implementation focuses on:

* Clean Architecture
* SOLID Principles
* Service Layer
* Scalability
* Maintainability
* Extensibility
* Separation of Concerns
* Testability

---

# Feature Flow

```
Client

    │

    ▼

TicketController

    │

    ▼

TicketService

    │

    ▼

EscalationService

    │

    ▼

NotificationManager

    │

    ▼

Create Notification Records

    │

    ▼

Dispatch Queue Jobs

    │

    ▼

SendNotificationJob

    │

    ▼

Notification Channel

    │

    ├──────────────► Email

    │

    └──────────────► Slack
```

---

# Recommendations

The following improvements could be considered in future versions.

## Dynamic Notification Channels

Allow administrators to enable or disable channels from the dashboard instead of configuration files.

---

## Notification Templates

Provide customizable templates for each notification channel.

---

## Escalation Reason

Store the reason why a ticket was escalated.

---

## Escalation Levels

Support multiple escalation levels.

Example:

* Level 1
* Level 2
* Level 3

---

## Audit Logs

Track every important ticket action including:

* Ticket creation
* Assignment
* Escalation
* Resolution
* Notification delivery

---

## Notification Dashboard

Create an administration page showing:

* Pending notifications
* Failed notifications
* Retry history
* Delivery statistics

---

## Manual Retry

Allow administrators to manually resend failed notifications.

---

## Rate Limiting

Protect notification providers against excessive requests.

---

## Monitoring

Integrate monitoring tools such as Laravel Horizon to observe queue performance and failed jobs.

---

# Conclusion

The solution was implemented with production-ready architecture in mind.

The notification system follows an extensible design that allows new notification channels to be introduced with minimal code changes while keeping the existing business logic unchanged.

Queue-based processing ensures that ticket escalation remains fast while notification delivery happens asynchronously with automatic retry support.
