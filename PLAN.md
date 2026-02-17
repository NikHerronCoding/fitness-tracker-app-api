# Workout Sessions Endpoint Plan

- [ ] Add a protected `GET /workouts` route in `routes/api.php` under the existing `auth:sanctum` group.
- [ ] Create `WorkoutSessionController@index` to fetch the authenticated user's sessions using `WorkoutSession::forUser(...)` and eager-load entries, sets, and exercise details.
- [ ] Build API resources/transformers to shape the session payload (session info plus ordered entries, sets, and exercise variant data).
- [ ] Add feature tests that cover listing sessions (authorized, unauthorized, and response structure/order).
- [ ] Iterate on optional filters/pagination (date range, active sessions) once the base endpoint works.
