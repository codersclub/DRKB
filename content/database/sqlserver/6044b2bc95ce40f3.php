<h1>Вывести список блокировок</h1>
<div class="date">01.01.2007</div>


<p>Можно стандартными средствами, но я предпочитаю свой способ, он мне кажется даёт более понятный результат.</p>
<pre>
Select * From
(
        select         convert (smallint, req_spid) As spid,
                Db_Name(rsc_dbid) As dbName,
                Object_Name(rsc_objid) As ObjId,
                rsc_indid As IndId,
                Case substring (v.name, 1, 4)
                        when 'FIL' then 'File'
                        when 'DB'  then 'Database'
                        when 'IDX' then 'Index'
                        when 'PAG' then 'Page'
                        when 'KEY' then 'Key'
                        when 'TAB' then 'Table'
                        when 'EXT' then 'Extent'
                        when 'RID' then 'Row'
                        else v.name 
                End As LockType,
                substring (rsc_text, 1, 16) as Resource,
                Case substring (u.name, 1, 8)
                        When 'S' then 'Shared' 
                        When 'U' then 'Update'
                        When 'X' then 'Exclusive'
                        When 'I' then 'Intent'
                        When 'IS' then 'Intent Shared'
                        When 'IX' then 'Intent Exclusive'
                        When 'IU' then 'Intent Update'
                        When 'SIX' then 'shared with intent exclusive'
                        When 'BU' then 'Bulk Update'
                        else u.name
                End As LockMode,
                substring (x.name, 1, 5) As Status
 
        from         master.dbo.syslockinfo,
                master.dbo.spt_values v,
                master.dbo.spt_values x,
                master.dbo.spt_values u
 
        where   master.dbo.syslockinfo.rsc_type = v.number
                        and v.type = 'LR'
                        and master.dbo.syslockinfo.req_status = x.number
                        and x.type = 'LS'
                        and master.dbo.syslockinfo.req_mode + 1 = u.number
                        and u.type = 'L'
) as t
Where dbName=Db_Name() and ObjId is not NULL
Order By ObjId, LockMode
</pre>
<p class="author">Автор: Vit</p>
