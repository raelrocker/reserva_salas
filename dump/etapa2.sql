select D.dept_name as Departamento, concat(E.first_name, ' ', E.last_name) as Empregado,  datediff(COALESCE(DE.to_date, current_date()), DE.from_date) as Dias
from dept_emp DE 
inner join departments D on D.dept_no = DE.dept_no
inner join employees E on E.emp_no = DE.emp_no
order by Dias desc 
limit 10;