<h1>Рисование без мерцания</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Mike Scott </div>

<p>...вот я и удивляюсь - почему я получаю мерцание, если я вызываю Repaint или Refresh, а не метод OnPaint напрямую? Или это просто "вариация на тему"? </p>

<p>Имеются две фазы обновления окна. В первой фазе, при выводе окна, Windows посылает ему сообщение WM_ERASEBKGND, сообщающее о необходимости стирания фона перед процедурой рисования. Затем посылается сообщение WM_PAINT, служащее сигналом для закрашивания "переднего плана". </p>

<p>Тем не менее, вы можете пропустить первую фазу, которая вызывает мерцание, одним из двух способов: первый способ заключается в том, что вы форсируете обновление сами, с помощью вызова функции Windows API InvalidateRect. На входе он получает дескриптор окна, указатель на закрашиваемую область - передаем NIL, если вы хотите отрисовать всю область окна - и третий параметр, сообщающий о необходимости очистки фона. Вот как раз последний параметр и должен содержать значение FALSE, если вы сами будете в методе Paint полностью отрисовывать всю область:</p>


<p>InvalidateRect( Handle, NIL, FALSE ) ;</p>


<p>Handle должен быть дескриптором формы или элемента управления. </p>

<p>Описав первый способ, я скажу, что существует другое подходящее решение - использовать функциональность VCL. Вы можете указать VCL не стирать фон, добавляя [ csOpaque ] к значению свойства ControlStyle, как показано ниже:</p>


<p>ControlStyle := ControlStyle + [ csOpaque ] ;</p>


<p>Это ограничивает заполнение заднего фона, но вы все еще можете видеть процесс "наполнения" области изображением, т.е. процесс рисования. В этом случае вы можете отделаться от эффекта мельтешения, рисуя на TBitmap и выводя его затем на экран командой CopyRect. </p>

<p>Если вы хотите углубиться в тему дальше, то я отошлю вас к моей статье "Optimizing Display Updates in Delphi" (Оптимизация обновления экрана в Delphi), опубликованной в первом выпуске журнала "Delphi magazine".</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
