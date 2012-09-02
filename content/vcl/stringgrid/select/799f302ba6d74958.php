<h1>Множественный выбор в TStringGrid</h1>
<div class="date">01.01.2007</div>

То же самое я проделывал и с DBGrid. (Пока не реализован Shift-MouseDown, только Ctrl-MouseDown). </p>
<p>Для TStringGrid вам нужно выполнить следующие шаги: </p>
<p>Заполните сетку, связывая Objects[0, ARow] с некоторым логическим объектом типа:</p>
<pre>
TBooleanObject = class(TObject)
public
  Flag: Boolean;
end;
</pre>

<p>В обработчике события OnMouseDown и OnKeyDown измените флаг, как того требует ситуация. </p>
<p>В обработчике события OnDrawCell отрисуйте строку согласно флагу Objects[0,ARow]. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
