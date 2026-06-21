# Code review document

## What was changed

- Whole module is structured in different classes in PHP 8+ manner
- Removed ini_set('display_errors', 'off') from the constructor
- Replaced hardcoded API keys with private variables in class.
- Replaced the off-by-one `for` loop + `switch` with a `foreach` over an
 array of LoanOfferClient implementations (one class per provider),
 so adding a new provider doesn't mean editing this file's control flow.
- Fixed the "ba_fin reuses the previous offer" bug: every client now
 returns its own value (or null), there is no shared/stale $offer var.
- Added strict typing, an enum for providers, and a LoanOffer
 value object instead of passing around untyped arrays with
 provider-specific magic keys ('zinsen' vs 'Interest').
- All HTML output is escaped (htmlspecialchars) to close the reflected
 XSS hole on the `amount` field.
- `amount` is validated with filter_input() before it ever reaches a URL.
- Network failures / bad JSON are handled explicitly (no `@` suppression).


## What could be more changed

- adding .env file for storing api keys and urls instead of private variables
- Since the view depends on the business logic of client. Conditions for showing table
can be changed. Currently, table doesn't show if any of API is not in function or if it has wrong response.
- Api data variables and $client could be marked as `readonly` variables


**Used AI Conversation for development:**

https://claude.ai/share/160357b4-5510-4329-9428-f63220cb1c89