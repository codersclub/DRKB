<h1>Использование InputBox и InputQuery</h1>
<div class="date">01.01.2007</div>


<p>Данная функция демонстрирует 3 очень мощных и полезных процедуры, интегрированных в Delphi. </p>
<p>Диалоговые окна InputBox и InputQuery позволяют пользователю вводить данные. </p>
<p>Функция InputBox используется в том случае, когда не имеет значения что пользователь выбирает для закрытия диалогового окна - кнопку OK или кнопку Cancel (или нажатие клавиши Esc). Если вам необходимо знать какую кнопку нажал пользователь (OK или Cancel (или нажал клавишу Esc)), используйте функцию InputQuery. </p>
<p>ShowMessage - другой простой путь отображения сообщения для пользователя.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  s, s1: string;
  b: boolean;
begin
  s := Trim(InputBox('Новый пароль', 'Пароль', 'masterkey'));
  b := s &lt;&gt; '';
  s1 := s;
  if b then
    b := InputQuery('Повторите пароль', 'Пароль', s1);
  if not b or (s1 &lt;&gt; s) then
    ShowMessage('Пароль неверен');
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
