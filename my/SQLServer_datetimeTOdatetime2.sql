--
-- change column datatype 'datetime' to 'datetime2' 
-- for all columns of all tables of database
--

declare @qry varchar(250)
declare cx cursor for
	select 'alter table ' + quotename(o.name) + ' alter column ' + quotename(c.name) + ' datetime2; '
	from sys.columns c
	  join
	  sys.objects o
	  on o.object_id = c.object_id
	where o.type = 'U'
	 and c.user_type_id = 61

	open cx

	fetch next from cx into @qry
	while @@FETCH_STATUS = 0
	begin   
		print @qry
		exec sp_executesql @qry	
		fetch next from cx into @qry
	end

	close cx
	deallocate cx