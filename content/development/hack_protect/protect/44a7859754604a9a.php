<h1>Защита shareware- программ</h1>
<div class="date">01.01.2007</div>


<p>Взято из FAQ: <a href="https://blackman.km.ru/myfaq/cont4.phtml" target="_blank">https://blackman.km.ru/myfaq/cont4.phtml</a></p>
<p>В качестве примера приведен небольшой участок программного кода,</p>
<p>позволяющий быстро создать защиту для программ SHAREWARE,</p>
<p>которая, не влияет на функциональность самой программы,</p>
<p>но настоятельно «просит» ее зарегистрировать и закрывает при каждом повторном запуске.</p>
<p>Технология данного метода заключается в том, что пользователь</p>
<p>может запустить программу только один раз за текущий сеанс Windows. Используйте обработчик события FormShow: </p>
<pre>
procedure TForm1.FormShow(Sender: TObject);
var
  atom: integer;
  CRLF: string;
begin
  if GlobalFindAtom('THIS_IS_SOME_OBSCUREE_TEXT') = 0 then
    atom := GlobalAddAtom('THIS_IS_SOME_OBSCUREE_TEXT')
  else
    begin
      CRLF := #10 + #13;
      ShowMessage('Данная версия предусматривает только один запуск'
        + 'в текущем сеансе Windows.' + CRLF
        + 'Для повторного запуска необходимо перезапустить Windows, или,'
        + CRLF + 'что лучше, - ' + CRLF + 'ЗАРЕГИСТРИРУЙТЕСЬ !');
      Close;
    end;
end;
</pre>

<p>Преимущество данного метода в том, что пользователю доступны все</p>
<p>возможности программы, но только до момента ее закрытия, или перезапуска системы.</p>
<p>Вся хитрость заключается в сохранении некоторой строки в системных</p>
<p>глобальных переменных («атомах») и последующей проверке ее в таблице «атомов» системы. </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
