---
Title: Использование классовых методов для выявления утечек памяти
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Использование классовых методов для выявления утечек памяти
===========================================================

Class Methods aply to the class level, in other words you don't need an
instance to call the method

I wish we could define class objects as well, but they doesn't exist in
Object Pascal, so we will do a trick, we are going to define a variable
in the implementation section of the unit, this variable will hold the
number of instances the class will have in a moment in time. Object
Oriented purist might claim about it, but it works, nobody is perfect
(not even Delphi!).

For example say you need to create instances of a class named TFoo, so
you create the following Unit.

We will define two class procedures: AddInstance(to increse the counter
of instances) and ReleaseInstance(to decrese the number of instances),
these are called in the constructor and the destructor acordingly.
Finally we define a class function NumOfInstances which returns the
actual number of instances.

Add a Initilialization and a Finalization section to the Unit, in the
Finalization section ask if the number of instances is \<\> 0, if this
is the case you known that you didn't destroy all the objects that you
created.

    unit U_Foo;
     
    interface
     
    uses
      Classes, Windows, SysUtils;
     
    type
      TFoo = class
      private
        class procedure AddInstance;
        class procedure ReleaseInstance;
      public
        constructor Create;
        destructor Destroy; override;
        class function NumOfInstances: Integer;
      end;
     
    implementation
     
    var
      TFoo_Instances: Integer = 0;
     
      { TFoo }
     
    class procedure TFoo.AddInstance;
    begin
      Inc(TFoo_Instances);
    end; //end of TFoo.AddInstance
     
    constructor TFoo.Create;
    begin
      AddInstance;
    end; //end of TFoo.Create
     
    destructor TFoo.Destroy;
    begin
      ReleaseInstance;
      inherited;
    end; //end of TFoo.Destroy
     
    class function TFoo.NumOfInstances: Integer;
    begin
      Result := TFoo_Instances;
    end; //end of TFoo.NumOfInstances
     
    class procedure TFoo.ReleaseInstance;
    begin
      Dec(TFoo_Instances);
    end; //end of TFoo.ReleaseInstance
     
    initialization
     
    finalization
     
      if TFoo_Instances <> 0 then
        MessageBox(0,
          PChar(Format('%d instances of TFoo active', [TFoo_Instances])),
          'Warning', MB_OK or MB_ICONWARNING);
     
    end.

