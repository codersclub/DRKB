<h1>Недоступная закладка в компоненте TTabbedNotebook</h1>
<div class="date">01.01.2007</div>


<p>Есть ли возможность в компоненте Tabbednotebook сделать какую-либо страницу недоступной? То есть не позволять пользователю щелкать на ней и видеть ее содержимое?</p>

<p>Да, такая возможность существует. Самый простой путь - удалить страницу, например так:</p>
<pre>
with TabbedNotebook do
  Pages.Delete(PageIndex);
</pre>




<p>и снова включить ее (при необходимости), перегрузив форму.</p>

<p>Блокировка (а не удаление) немного мудренее, поскольку необходима организация цикла в процедуре создания формы, присваивающая имена закладкам компонента TabbedNotebook. Например так:</p>
<pre>
J := 0;
with TabbedNotebook do
  for I := 0 to ComponentCount - 1 do
    if Components[I].ClassName = 'TTabButton' then
      begin
        Components[I].Name := ValidIdentifier(TTabbedNotebook(
          Components[I].Owner).Pages[J]) + 'Tab';
        Inc(J);
      end;
</pre>


<p>где ValidIdentifier ValidIdentifier - функция, которая возвращает правильный Pascal-идентификатор, производный от строки 'Tab':</p>
<pre>
function ValidIdentifier(theString: str63): str63;
{--------------------------------------------------------}
{ Конвертирует строку в правильный Pascal-идентификатор, }
{ удаляя все неправильные символы и добавляя символ '_', }
{ если первый символ - цифра                             }
{--------------------------------------------------------}
var
  I, Len: Integer;
begin
  Len := Length(theString);
  for I := Len downto 1 do
    if not (theString[I] in LettersUnderscoreAndDigits) then
      Delete(theString, I, 1);
  if not (theString[1] in LettersAndUnderscore) then
    theString := '_' + theString;
  ValidIdentifier := theString;
end; {ValidIdentifier}
</pre>

<p>Затем мы можем сделать закладку компонента TabbedNotebook недоступной:</p>
<pre>
with TabbedNotebook do
  begin
    TabIdent := ValidIdentifier(Pages[PageIndex]) + 'Tab';
    TControl(FindComponent(TabIdent)).Enabled := False;
{ Переключаемся на первую доступную страницу: }
    for I := 0 to Pages.Count - 1 do
      begin
        TabIdent := ValidIdentifier(Pages[I]) + 'Tab';
        if TControl(FindComponent(TabIdent)).Enabled then
          begin
            PageIndex := I;
            Exit;
          end;
      end; {for}
  end; {with TabbedNotebook}
</pre>


<p>следующий код восстанавливает доступность страницы:</p>
<pre>
with TabbedNotebook do
  for I := 0 to Pages.Count - 1 do
    begin
      TabIdent := ValidIdentifier(Pages[I]) + 'Tab';
      if not TControl(FindComponent(TabIdent)).Enabled then
        TControl(FindComponent(TabIdent)).Enabled := True;
    end; {for}
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

