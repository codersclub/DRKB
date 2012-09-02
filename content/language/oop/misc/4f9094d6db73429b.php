<h1>Как забыть о необходимости разрушать объекты?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  ISelfDestroy = interface;
  //forget about GUID, if you are not using COM
 
  TSelfDestroy = class(TInterfacedObject, ISelfDestroy)
  private
    FObject: TObject;
  public
    constructor Create(AObject: TObject);
    destructor Destroy; override;
  end;
 
implementation
 
constructor TSelfDestroy.Create(AObject: TObject);
begin
  FObject := AObject;
end;
 
destructor TSelfDestroy.Destroy;
begin
  FreeAndNil(FObject);
  inherited;
end;
 
 
// So when you use, just do like this...
 
procedure TForm1.Button1Click(Sender: TObject);
var
  MyObject: TMyObject;
  SelfDestroy: TSelfDestroy;
  begin
  MyObject    := TMyObject.Create;
  SelfDestroy := TSelfDestroy.Create(MyObject);
  // The MyObject will free automatically as soon as TSelfDestroy
  // goes out of scope.
  // Carry on your code here...
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
