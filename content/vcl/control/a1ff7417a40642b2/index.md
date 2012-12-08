---
Title: Недоступная закладка в компоненте TTabbedNotebook
Date: 01.01.2007
---


Недоступная закладка в компоненте TTabbedNotebook
=================================================

::: {.date}
01.01.2007
:::

Есть ли возможность в компоненте Tabbednotebook сделать какую-либо
страницу недоступной? То есть не позволять пользователю щелкать на ней и
видеть ее содержимое?

Да, такая возможность существует. Самый простой путь - удалить страницу,
например так:

    with TabbedNotebook do
      Pages.Delete(PageIndex);

и снова включить ее (при необходимости), перегрузив форму.

Блокировка (а не удаление) немного мудренее, поскольку необходима
организация цикла в процедуре создания формы, присваивающая имена
закладкам компонента TabbedNotebook. Например так:

    J := 0;
    with TabbedNotebook do
      for I := 0 to ComponentCount - 1 do
        if Components[I].ClassName = 'TTabButton' then
          begin
            Components[I].Name := ValidIdentifier(TTabbedNotebook(
              Components[I].Owner).Pages[J]) + 'Tab';
            Inc(J);
          end;

где ValidIdentifier ValidIdentifier - функция, которая возвращает
правильный Pascal-идентификатор, производный от строки \'Tab\':

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

Затем мы можем сделать закладку компонента TabbedNotebook недоступной:

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

следующий код восстанавливает доступность страницы:

    with TabbedNotebook do
      for I := 0 to Pages.Count - 1 do
        begin
          TabIdent := ValidIdentifier(Pages[I]) + 'Tab';
          if not TControl(FindComponent(TabIdent)).Enabled then
            TControl(FindComponent(TabIdent)).Enabled := True;
        end; {for}

Взято с <https://delphiworld.narod.ru>
