<h1>TProgressBar, который не отображает реального прогресса</h1>
<div class="date">01.01.2007</div>


<p>Начиная с виньХР появились в системе забавные ProgressBar'ы, которые не отображают реального "прогресса", а лишь отображают, что что-нибудь работает... такой же появляется при загрузки виндыХР (бегает пару чёрточек слева вправо, а потом обратно возвращаются в начало). Такой же прогресс отображается если в ХР выбрать изображение, в меню нажать на Print (Печать), и вэтом диалоге при выборе шаблона печати - тоже такого стиля есть прогресс. (надеюсь, что теперь ясно что я имел в виду&nbsp; )</p>
<p>И сам вопрос: как такой сделать на делфи? </p>
<p>Судя по MSDN, надо</p>
<pre>

 const
  PBS_MARQUEE            = $08;
  PBM_SETMARQUEE         = WM_USER+10;
 
...
 
  with ProgressBar1 do
  begin
    SetWindowLong (Handle, GWL_STYLE, (GetWindowLong (Handle, GWL_STYLE) or PBS_MARQUEE));
    Perform(PBM_SETMARQUEE, 1, 50);
  end;
</pre>

<p>(вместо 50 поставь время перемещения кубиков)</p>
<p>Цитата (MSDN) </p>
<p>Use this message when you do not know the amount of progress toward completion but wish to indicate that progress is being made.&nbsp; </p>
<p>PS: чтобы это работало, нужно включить в прогу XP-манифест </p>
<p class="author">Автор: p0s0l</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
