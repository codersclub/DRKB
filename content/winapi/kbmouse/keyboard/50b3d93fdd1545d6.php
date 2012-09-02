<h1>Как отличить нажат правый или левый SHIFT?</h1>
<div class="date">01.01.2007</div>


<pre>
if ((Word(GetKeyState(VK_LSHIFT)) and $8000) &lt;&gt; 0) then
  begin
  end;
 
if ((Word(GetKeyState(VK_RSHIFT)) and $8000) &lt;&gt; 0) then
  begin
  end;
</pre>
<p>работает под Win NT/2000, но не работает под Win95.</p>
<p class="author">Автор ответа: CHERRY</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>В 95 катит следующее:</p>
<pre>

RSHIFT = 36h
LSHIFT = 2Ah
asm
  in al, 60h
  cmp al, 36h
  jne @@exit
  mov tt,1
  @@exit:
end;
if tt = 1 then ShowMessage ('Right Shift'); 
</pre>
<p class="author">Автор ответа: Baa</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>
procedure TDecEditForm.Memo1KeyPress(Sender: TObject; var Key: Char);
VAR s:String;  RL:Byte;
begin
IF key=CHR(VK_RETURN) Then
  Begin
    //WIN NT/2000
    If (GetVersion() and $80000000)=0 then
      BEGIN
        IF ((Word(GetKeyState(VK_LSHIFT)) and $8000)&lt;&gt;0)  Then
          Begin
          End;
    IF ((Word(GetKeyState(VK_RSHIFT)) and $8000)&lt;&gt;0)  Then
      Begin
      End;
  End
ELSE
  //WIN 9.x
  Begin
    asm
      mov ah,2
      int $16
      mov RL,al
    end;
    if 1 = (RL and 1) then  //  ПРАВЫЙ SHIFT НАЖАТ+ENTER
      Begin
      End;
    if 2 = (RL and 2) then  //  ЛЕВЫЙ SHIFT НАЖАТ+ENTER
      Begin
      End;
  End; 
//WIN 9.x
END;
End;
</pre>
<p class="author">Автор ответа: CHERRY</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

