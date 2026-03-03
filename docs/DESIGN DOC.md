
1) Problem

What user pain are we solving?

The core concept of what we want to accomplish with this app is to be able to log fitness session data. There are many fitness tracking apps out there but none really hit the core concept of what I am trying to achieve with this project.

Principles:

    1. Users can select literally ANY exercise and it should work. Ex: 15 degree incline bench press to pins with 3-1-3 tempo. Cardio and Time based exercises will also be added eventually.

    2. Users can freely export their data in a excel or csv file for export to other databases.

    3. The users will be able to freely use the app, create any amount of programs and store any amount of sessions. Historical data will be saved with no limitation.

What is in scope and out of scope?

Out of scope: Wearable fitness data, video / BLOB storage.

2) Goals and non-goals

Goals: measurable outcomes (latency, correctness, UX, etc.)

    1. The application can safely scale to 10,000 users with minimal cost to the owner of this project (less than 100 dollars a month).
    2. The user can easily and accurately log all weightlifting related fitness training data, including: weight, sets, RIR/RPE for any arbitrary exercise.
    3. The application will be accessible using a web browser and a mobile web application.
    4. A typical user will only have access for for their workout history, created workouts and created exercises.
    5. An admin page will exist where the admin can create new global exercises and workout programs for everyone.
    6. A user will be able to export their training data in either CSV or .xlsx format
    7. The user can access all of their session related data in a quick manner. >500ms, ideally less than 250ms.

Non-goals: explicitly not doing (prevents scope creep)

Out of scope: Wearable fitness data, video / BLOB storage.

3) Proposed solution (high level)

5–10 bullets describing the approach

- Store all of user/workout data in a persistent DB
- API layer will use DB to store data, handle Authentication, authorization, and business logic.
- Client will be focused on presentation layer / gathering data from api for user
- Workout data will be stored in SQL tables where join operations will build the complex data structures required
- Proposed Tech Stack:
    DB: Sqlite for development + test purposes. Postgres 
    API / BE: PHP / Laravel
    Front End / Client side: React Native (mobile) / React. Utilizing centralized state management solution, most likely redux.

    React Sends API request -> Laravel Based API -> Data Access Sqllite -> Laravel API sends back response

Include a simple flow: request → validation → write → response

4) Data model

Tables/entities and relationships


# Core Tables:

## user
    defined using sanctum Auth in laravel

 ## Workout-Session

### Fields: 
    id -> Primary Key, not null, unique
    user-> Foreign Key, not null
    startedAt -> DateTime, nullable
    completedAt -> DateTime, nullable
    sessionEffort -> INT
    notes -> text 256 chars max?

### Indexes:
    user, startedAt

## Workout-Entry

    ### Fields:
    id -> Primary Key, not null, unique
    workout_session_id -> Foreign Key, not null
    exercise_variant_id -> Foreign Key, not null
    position -> int, not null,
    group_id -> int, nullable,
    group_position -> int, nullable
    notes -> text, 256 char cap, validation in UI & API
    entry_type  -> string/enum, work, warmup back-off, drop, amrap, test, rehab, not null,
    deleted_at -> date,



    ### Indexes:
    workout_session_id, position


# exercise_modifiers

Catalog of allowed modifiers.

## Fields

id PK

    name string (unique-ish)
    Examples: Straps, Pause, Tempo, To Pins, Bands

    value_type enum(none,int,decimal,text) not null

    none = straps, belt, chalk

    int = pause counts, pins level (if you encode it), etc

    decimal = something measured (rare but useful)

    text = tempo 3-1-3, notes like touch and go if you want it as text

    unit string nullable
    Examples: counts, sec, kg, lb, cm

    created_by_user_id FK nullable (admin tool later, optional)

is_active boolean not null default true



created_at, updated_at

Indexes

UNIQUE (name)

# workout_entry_modifiers

Applied modifiers for a specific entry.

## Fields

id PK

    workout_entry_id FK not null

    exercise_modifier_id FK not null

    value_int int nullable

    value_decimal decimal(8,2) nullable

    value_text string (or text) nullable

    position int not null (order in UI)

    created_at, updated_at

Constraints you probably want

UNIQUE (workout_entry_id, exercise_modifier_id)
Prevents “Pause” being added twice to the same entry. If you ever want duplicates, drop this.

## Indexes

    INDEX (workout_entry_id, position)

    INDEX (exercise_modifier_id) (helps analytics/export filters)

 Workout-Set

# workout_sets

One row per set performed.

## Fields

id PK

    workout_entry_id FK not null

    position int not null (set order: 1,2,3...)

    set_type enum nullable (or string)
    Examples: warmup, work, top, backoff, amrap
    

    reps int nullable

    weight decimal(7,2) nullable

    weight_unit enum(lb,kg) not null default lb (or store on session/user instead)

    rir decimal(3,1) nullable  already chose 0.5 increments)

    notes text nullable

    created_at, updated_at

Indexes

INDEX (workout_entry_id, position)

Notes

If you log cardio later, you’ll add nullable fields like duration_seconds, distance_meters, etc. Keep the strength ones nullable now.


Key fields

Constraints (NOT NULL, unique, foreign keys, cascade rules)

Indexes you’ll add and why (tie to query patterns)

5) API / interface

Endpoints or function signatures

Request/response examples

Error cases (400/401/403/404/409/422)

6) Business rules and invariants

Bullet list of rules that must always be true

Where enforced: DB vs app layer

7) Read patterns

Top 3–5 queries the UI needs

Expected sizes and performance notes

Any caching or aggregation plans

8) Edge cases and failure modes

Concurrency (double submit, retries)

Idempotency plan (how you avoid duplicates)

Partial failures

9) Security and privacy

Authz rules

Data access boundaries (user can only see own data)

PII considerations

10) Rollout and testing

Migration plan

Backfill (if any)

Test plan (unit, integration)

Observability (logs/metrics)

11) Alternatives considered

2–3 options you rejected and why

12) Open questions

What you still need to decide

That’s formal. That’s what “design” is at work. You’re writing down decisions, constraints, and tradeoffs.

What it looks like in practice

For a small feature: 1–2 pages in Markdown.

For a bigger feature: 3–6 pages.

Diagrams optional, but a small ER diagram or sequence diagram helps.

Where you put it

At work: a PRD/design doc in Confluence, Notion, Google Doc, or a Markdown file in the repo.

For your app: /docs/design/feature-name.md in your repo.

How to know it’s “good enough”
