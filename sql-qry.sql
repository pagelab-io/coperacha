1. update moneyboxes
    set end_date = date_add(date(created_at), interval FLOOR(1 + (RAND() * 30)) DAY);

2. SELECT id, DATE(created_at), end_date, datediff(end_Date,created_at) days FROM moneyboxes ORDER BY created_at;

3. update moneyboxes
    set collected_amount = FLOOR(1 + (RAND() * 1000));