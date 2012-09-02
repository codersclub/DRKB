<h1>Как создать и вызвать модальную форму?</h1>
<div class="date">01.01.2007</div>



<pre>
ModalForm := TModalForm.Create(Self);
try
  ModalForm.ShowModal;
finally 
  ModalForm.Free;
end;
</pre>

