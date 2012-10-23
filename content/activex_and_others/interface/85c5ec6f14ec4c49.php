<h1>Тест на корректность GUID и интерфейсов</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Nomadic </div>

<p>Как осуществить минимальный тест на корректность глобального идентификатора (GUID), и интерфейсов, унаследованных от IDispatch (и, следовательно, поддерживающих методы автоматизации)? </p>

<p>Вызовите CreateRemoteComObject, передав GUID интерфейса и имя компьютера, к которому Вы пытаетесь подключиться. Если функция вернет ошибку, то наличествует проблема сервера, иначе возможная проблема относится к клиенту.</p>

<pre>
const
  MyGUID = '{444...111}'; //Whatever the guid is...
 
var
  Unk: IUnknown;
  Disp: IDispatch;
 
begin
  { Make sure this line works correctly }
  Unk := CreateRemoteComObject('server1',
    StringToGUID(MyGUID));
 
  { If it does, then cast it to a IDispatch }
  Disp := Unk as IDispatch;
end;
</pre>



<p>Если этот кусок кода работает, а проблема остается, то Вам требуется шаг за шагом пройти через код клиента и найти, где он дает трещину. Если не сможете этого обнаружить, Вам придется запустить сервер под отладчиком и установить связь с клиентом, чтобы Вы могли произвести отладку рядом со местом, дающем слабину. </p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
