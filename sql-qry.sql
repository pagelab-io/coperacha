1. update moneyboxes
    set end_date = date_add(date(created_at), interval FLOOR(1 + (RAND() * 30)) DAY);

2. SELECT id, DATE(created_at), end_date, datediff(end_Date,created_at) days FROM moneyboxes ORDER BY created_at;

3. update moneyboxes
    set collected_amount = FLOOR(1 + (RAND() * 1000));


4. SELECT SQL_CALC_FOUND_ROWS * FROM payments LIMIT 0,1;

   SELECT FOUND_ROWS();

   SELECT
      CASE method
        WHEN 'O' THEN 'O'
        WHEN 'X' THEN 'X'
        ELSE 'P' END AS method,

      COUNT(method) AS qty,
      COUNT(method)/ 1708 *100 AS percent

     FROM payments
     GROUP BY method;


5. update payments set method = 'S' where id between 1200 and 1800
