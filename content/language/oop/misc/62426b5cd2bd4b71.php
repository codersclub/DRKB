<h1>Как можно работать с объектами не заботясь об их разрушении?</h1>
<div class="date">01.01.2007</div>



<p>Вначале сделаем интерфейс для нашего объекта:</p>

<pre>
type
  IAutoClean = interface
    ['{61D9CBA6-B1CE-4297-9319-66CC86CE6922}']
  end;
 
  TAutoClean = class(TInterfacedObject, IAutoClean)
  private
    FObj: TObject;
  public
    constructor Create(AObj: TObject);
    destructor Destroy; override;
  end;
 
implementation
 
constructor TAutoClean.Create(AObj: TObject);
begin
  FObj := AObj;
end;
 
destructor TAutoClean.Destroy;
begin
  FreeAndNil(FObj);
  inherited;
end;
</pre>

<p>А теперь будем использовать его вместо объекта:</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  a: IAutoClean;
    //must declare as local variable, so when this procedure finished, it's out of scope
  o: TOpenDialog; //any component
begin
  o := TOpenDialog.Create(self);
  a := TAutoClean.Create(o);
  if o.Execute then
    ShowMessage(o.FileName);
end;
</pre>


<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

