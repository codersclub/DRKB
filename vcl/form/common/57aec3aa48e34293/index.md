---
Title: Узнать класс формы
Date: 01.01.2007
---


Узнать класс формы
==================

::: {.date}
01.01.2007
:::

    type 
      PFieldClassTable = ^TFieldClassTable; 
      TFieldClassTable = packed record 
        Count: Smallint; 
        Classes: array[0..8191] of ^TPersistentClass; 
      end; 
     
    function GetFieldClassTable(AClass: TClass): PFieldClassTable; assembler; 
    asm 
            MOV     EAX,[EAX].vmtFieldTable 
            OR      EAX,EAX 
            JE      @@1 
            MOV     EAX,[EAX+2].Integer 
    @@1: 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
      procedure Display( const S: String ); 
      begin 
        memo1.lines.add( S ); 
      end; 
    var 
      pFCT: PFieldClassTable; 
      aClass: TClass; 
      i: SmallInt; 
    begin 
      memo1.clear; 
      aClass:= Classtype; 
      While aClass <> TPersistent Do Begin 
        Display('Registered classes for class '+aClass.Classname ); 
        pFCT := GetFieldClasstable( aClass ); 
        If not Assigned( pFCT ) Then 
          Display('  No classes registered') 
        Else Begin 
          Display( format('  %d classes registered', [pFCT^.Count])); 
          for i:= 0 to pFCT^.Count -1 do 
            Display( '  '+pFCT^.Classes[i]^.ClassName ); 
        End; 
        aClass := aClass.ClassParent; 
      End 
    end;
