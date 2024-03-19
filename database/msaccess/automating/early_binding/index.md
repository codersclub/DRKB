---
Title: Открытие доступа (раннее связывание)
Date: 01.01.2007
---


Открытие доступа (раннее связывание)
==============================

Прежде чем вы сможете использовать этот метод, вы должны импортировать библиотеку типов (MSAcc8.olb для Access 97).

Одним из способов запуска Access является попытка Excel выполнить вызов GetActiveObject,
чтобы получить работающий экземпляр Access, но поместить вызов CoApplication.Create
в предложение исключения. 

Но исключения работают медленно и могут вызвать проблемы в среде IDE для людей,
которым нравится, когда для параметра Break On Exception установлено значение True.

Следующий код устраняет необходимость в конструкции **try... except**,
избегая использования OleCheck для GetActiveObject в случае, когда Access не запущен.

      uses Windows, ComObj, ActiveX, Access_TLB;
      var 
        Access: _Application; 
        AppWasRunning: boolean; // tells you if you can close Access when you've finished
        Unknown: IUnknown; 
        Result: HResult; 
      begin 
        AppWasRunning := False;

        {$IFDEF VER120}      // Delphi 4
        Result := GetActiveObject(CLASS_Application_, nil, Unknown); 
        if (Result = MK_E_UNAVAILABLE) then 
          Access := CoApplication_.Create 
     
        {$ELSE}              // Delphi 5
        Result := GetActiveObject(CLASS_AccessApplication, nil, Unknown); 
        if (Result = MK_E_UNAVAILABLE) then 
          Access := CoAccessApplication.Create 
        {$ENDIF}  
              
        else begin 
          { make sure no other error occurred during GetActiveObject } 
          OleCheck(Result); 
          OleCheck(Unknown.QueryInterface(_Application, Access)); 
          AppWasRunning := True; 
        end; 
        Access.Visible := True;
        ...

**Вариант без использования библиотеки типов**

Автоматизация намного проще и быстрее с использованием библиотек типов (раннее связывание),
поэтому вам следует избегать вариантов работы без их использования, если это вообще возможно.
Но если вы действительно без них не можете, то вот как начать:

            var 
              Access: Variant; 
            begin 
              try 
                Access := GetActiveOleObject('Access.Application');    
              except 
                Access := CreateOleObject('Access.Application');    
              end; 
              Access.Visible := True; 
     
