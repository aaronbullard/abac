# ABAC

Attribute Based Access Control

## Getting started

Clone repo.

#### Install dependencies

From within the cloned folder `abac` run:

Composer dependencies

```
composer install
```

#### Testing

From within the cloned folder `abac`:

Run `composer test`

#### Using ABAC

This ABAC system is comprised of *Policies*, *Rules* and *Conditions*.

A Policy contains one or many Rules, and a Rule contains one or many Conditions.

1) Policies
- A policy can be of two types: *ACCEPT* or *DENY*
  - Only one *ACCEPT* policy is required to pass in order for a user to access a resource.  Other *ACCEPT* policies can still fail.
  - Conversely, if just one *DENY* policy returns `TRUE`, then access is denied despite any successful *ACCEPT* policies which may have passed.
  - A Policy contains one or many Rules and when resolved (`$policy->validate($request)`), all rules must resolve `TRUE` for the policy to return `TRUE`.

2) Rules
- A Rule contains one or many Conditions, and like Policies, when resolved all conditions must return `TRUE` for the Rule to return `TRUE`.

3) Conditions
- A Condition is composed of three parts.
  - Left side value
  - Right side value
  - The operator to evaluate the two against
- Left and right side values are persisted via string dot notation and gets resolved from the ABAC Request object.
