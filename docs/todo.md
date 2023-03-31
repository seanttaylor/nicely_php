* Refactor all calls to `get_user_by_id` to ensure calling clients do `to_array()` on the result of `get_user_by_id` since the method now returns a `User` object instead of an `Array`

