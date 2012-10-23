<h1>Послать E-mail</h1>
<div class="date">01.01.2007</div>


<pre>
Exec master.dbo.xp_sendmail 
  @recipients='nevzorov@yahoo.com', 
  @Subject='MS SQL Test',
  @message='This is email body!'
</pre>
<div class="author">Автор: Vit</div>

