Как можно открыть отчет (в режиме print preview а также print direct) в MS Access?
==================================================================================

::: {.date}
01.01.2007
:::

    var
      Access: Variant;
    begin
      // Открываем Access
      try
        Access := GetActiveOleObject('Access.Application');
      except
        Access := CreateOleObject('Access.Application');
      end;
      Access.Visible := True;
     
      // Открываем базу данных
      // Второй параметр указывает - будет ли база открыта в Exclusive режиме
      Access.OpenCurrentDatabase('C:\My Documents\Books.mdb', True);
     
      // открываем отч?т
      {Значение второго пораметра может быть одним из следующих
      acViewDesign, acViewNormal, or acViewPreview. acViewNormal,
      которые устанавливаются по умолчанию, для печати отч?та.
      Если Вы не используете библиотеку типов, то можете определить
      эти значения следующими:
     
      const
      acViewNormal = $00000000;
      acViewDesign = $00000001;
      acViewPreview = $00000002;
     
      Третий параметр - это имя очереди для текущей базы данных.
      Четв?ртый параметр - это строка для SQL-евского WHERE -
      то есть строка SQL, минус WHERE.}
     
      Access.DoCmd.OpenReport('Titles by Author', acViewPreview, EmptyParam,
        EmptyParam);
     
      < ... >
     
      // Закрываем базу данных
      Access.CloseCurrentDatabase;
     
      // Закрываем Access
      {const
      acQuitPrompt = $00000000;
      acQuitSaveAll = $00000001;
      acQuitSaveNone = $00000002;}
      Access.Quit(acQuitSaveAll);
    end;
