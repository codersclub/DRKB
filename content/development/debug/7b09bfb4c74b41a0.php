<h1>Использование классовых методов для выявления утечек памяти</h1>
<div class="date">01.01.2007</div>



<p>Class Methods aply to the class level, in other words you donґt need an instance to call the method </p>

<p>I wish we could define class objects as well, but they doesnґt exist in Object Pascal, so we will do a trick, we are going to define a variable in the implementation section of the unit, this variable will hold the number of instances the class will have in a moment in time. Object Oriented purist might claim about it, but it works, nobody is perfect (not even Delphi!). </p>

<p>For example say you need to create instances of a class named TFoo, so you create the following Unit. </p>

<p>We will define two class procedures: AddInstance(to increse the counter of instances) and ReleaseInstance(to decrese the number of instances), these are called in the constructor and the destructor acordingly. Finally we define a class function NumOfInstances which returns the actual number of instances. </p>

<p>Add a Initilialization and a Finalization section to the Unit, in the Finalization section ask if the number of instances is &lt;&gt; 0, if this is the case you known that you didinґt destroy all the objects that you created. </p>

<pre>
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
 
  if TFoo_Instances &lt;&gt; 0 then
    MessageBox(0,
      PChar(Format('%d instances of TFoo active', [TFoo_Instances])),
      'Warning', MB_OK or MB_ICONWARNING);
 
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
