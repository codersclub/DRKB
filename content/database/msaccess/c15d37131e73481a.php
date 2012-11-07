<h1>Как скопировать таблицу из одной базы данных в другую?</h1>
<div class="date">01.01.2007</div>



<p>f I am not wrong you have an Access db with multiple tables and you want to copy one of these tables into another Access db. For this case i would do the next:</p>

1.        Create database TrasportDB.mdb - use ADOX.</p>
2.        Copy table from source table into TransportDB.mdb with Select * Into [TransportTable] in "FullPath\TransportDB.mdb" From SourceTable.</p>
3.        Deliver TransportDB.mdb on destination computer.</p>
4.        Copy table from TransportTable into DestTable with Select * Into [DestTable] From [TransportTable] in "FullPath\TransportDB.mdb".</p>

<p>FullPath is the path to TransportDB.mdb and is different on source and dest computers.</p>

<p>This way you will use native access methods that should be more reliable and faster than using ADO methods. If you need to perform more complete tasks you should use replication from Microsoft Jet and Replication objects (import this typelib).</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
