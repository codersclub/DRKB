---
Title: Примеры работы с репортами
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Примеры работы с репортами
==========================

В следующем небольшом примере я покажу, как можно вызвать отчет в MS Access:

    var
      Access: Variant;
    begin
      // open the Access application
      try
        Access := GetActiveOleObject('Access.Application');
      except
        Access := CreateOleObject('Access.Application');
      end;
      Access.Visible := True;
     
      // open the database
      //The second parameter specifies whether you want to open the database in Exclusive mode
     
      Access.OpenCurrentDatabase('C:\My Documents\Books.mdb', True);
     
    // open the report
    {The value for the second parameter should be one of
    acViewDesign, acViewNormal, or acViewPreview. acViewNormal, which is the default, prints the report immediately. If you are not using the type library, you can define these values like this:
     
    const
    acViewNormal = $00000000;
    acViewDesign = $00000001;
    acViewPreview = $00000002;
     
      The third parameter is for the name of a query in the current
      database.The fourth parameter is for a SQL WHERE clause - the string must be valid
      SQL, minus the WHERE.}
     
      Access.DoCmd.OpenReport('Titles by Author', acViewPreview,
        EmptyParam, EmptyParam);
     
      { ... }
        // close the database
      Access.CloseCurrentDatabase;
     
      // close the Access application
        {const
          acQuitPrompt = $00000000;
          acQuitSaveAll = $00000001;
          acQuitSaveNone = $00000002;}
      Access.Quit(acQuitSaveAll);
    end;

