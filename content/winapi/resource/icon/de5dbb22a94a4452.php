<h1>Изменение иконки приложения</h1>
<div class="date">01.01.2007</div>

Присвойте свойству Application.Icon другую иконку и вызовите функцию</p>
<pre>
InvalidateRect(Application.Handle, NIL, True); 
</pre>
<p>... для немедленной перерисовки.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr /><p class="p_Heading1">Изменять иконку приложения или окна во время его работы</p>
<p>Изменять иконку приложения или окна достаточно просто - для этого у TApplication и TForm предусмотрено свойство Icon. Смена иконки может вестись обычным присвоением свойству Icon нового значения:</p>
<pre>
Form1.Icon := Image1.Picture.Icon;
</pre>
<p>При этом происходит не присвоение указателя (как казалось бы), а копирование данных посредством вызова Assign, который производится в методе TForm.SetIcon</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p class="p_Heading1">Загрузка иконки из ресурса</p>
<p>Загрузка производится типовым вызовом API:</p>
<pre>
Form1.Icon.Handle := LoadIcon(hInstance, 'имя иконки в ресурсе');
</pre>
<p>Причем имя в ресурсе желательно писать всегда в верхнем регистре</p>
<p>Все сказанное выше пригодно и для приложения, только в этом случае вместо Form1 выступает Application. Для принудительной перерисовки кнопки приложения в панеле задач можно применить вызов</p>
<pre>
InvalidateRect(Application.Handle, nil, True);
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr /><p>Пример организации простейшей анимации иконки приложения</p>
<pre>
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  inc(IconIndex);
  case IconIndex of
    1 : Application.Icon.Assign(Image1.Picture.Icon);
    2 : Application.Icon.Assign(Image2.Picture.Icon);
    else IconIndex := 0;
  end;
  InvalidateRect(Application.Handle, nil, True);
end;
</pre>
<p>При этом естественно предполагается, что в Image1 и Image2 загружены иконки.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr /><p class="p_Heading1">Как заставить приложение показывать различные иконки при различных разрешениях дисплея?</p>
<p>Для этого достаточно текущее разрешение экрана и в соответствии с ним изменить дескриптор иконки приложения. Естественно, что Вам придется создать в ресурсах новые иконки.</p>
<p>Поместите следующий код в файл проекта (.DPR) Вашего приложения:</p>
<pre>
Application.Initialize;
Application.CreateForm(TForm1, Form1);
case GetDeviceCaps(GetDC(Form1.Handle), HORZRES) of
   640 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON640');
   800 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON800');
  1024 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON1024');
  1280 : Application.Icon.Handle := LoadIcon (hInstance, 'ICON1280');
end;
Application.Run;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


