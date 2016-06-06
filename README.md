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

## Using ABAC

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

#### Example
```
<?php

use ABAC\Services\ABACManager;
use ABAC\Services\Request;
use ABAC\Entities\Policy;
use ABAC\Entities\Rule;
use ABAC\Entities\Condition;
use ABAC\Entities\User;
use ABAC\Entities\Environment;
use ABAC\Entities\Operators\Equals;
use ABAC\Entities\Operators\GreaterThanInclusive;

// Make rules
$rules = [];

$rules[] = new Rule('voter', "User is a US citizen of age", [
  new Condition('$.user.age', new GreaterThanInclusive, 18),
  new Condition('$.user.country', new Equals, 'USA')
]);

$rules[] = new Rule('Election Day', "Only voting on election day", [
  new Condition('$.environment.day', new Equals, '2016-11-08')
]);

// Set policies to ABAC
$abac = ABAC::create([new Policy('Voting', 'Policy to allow voting', $rules)]);

// Set context
$user = new User;
$user->age = 25;
$user->country = 'USA';

$env = new Environment;
$env->day = '2016-11-08';

$request = new Request('POST', '/votes', $user, $env);

// Resolve
$allowed = $abac->validate( $request );

// $this->assertTrue( $allowed );

```
