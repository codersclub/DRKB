<h1>Транзакции и откат при ошибках</h1>
<div class="date">01.01.2007</div>


<pre>
Begin Tran
 
  Declare @ErrorCode  
 
  Update MyTable
  Set MyField1=MyField2
  Where MyField3=1
 
  Set @ErrorCode=@@Error
 
If @ErrorCode &lt;&gt; 0 Rollback Else Commit
</pre>
<p class="author">Автор: Vit</p>
