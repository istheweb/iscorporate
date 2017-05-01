<?php

Event::listen('issue.afterCreate', 'Istheweb\IsCorporate\Listeners\EmailSupportTeam');
Event::listen('issue.wasClosed', 'Istheweb\IsCorporate\Listeners\IssueWasClosedEmail');
Event::listen('issue.newReply', 'Istheweb\IsCorporate\Listeners\ReplyEmail');
Event::listen('budget.sendClient', 'Istheweb\IsCorporate\Listeners\EmailClientBudget');