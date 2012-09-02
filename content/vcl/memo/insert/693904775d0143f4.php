<h1>Вставка текста в TMemo в текущую позицию</h1>
<div class="date">01.01.2007</div>


<pre>
SendMessage(Memo.Handle, EM_REPLACESEL, 0, PCHAR('Delphi World - это КРУТО!'));
 
 
 
 
 
Var TempBuf :Array [0..255] of Char;
SendMessage(Memo.Handle, EM_REPLACESEL, 0, StrPCopy(TempBuf,'Delphi World - это КРУТО!'));
 
 
 
 
 
Memo1.SelText := 'Delphi World!';
 
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
