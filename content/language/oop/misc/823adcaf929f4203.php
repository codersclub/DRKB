<h1>Сгруппировать свойства наподобие Font</h1>
<div class="date">01.01.2007</div>


<p>...чтобы сгруппировать свойства наподобие Font, вам необходимо создать наследника (подкласс) TPersistent. Например:</p>
<pre>
TBoolList = class(TPersistent)
  private
    FValue1: Boolean;
    FValue2: Boolean
  published
    property Value1: Boolean read FValue1 write FValue1;
    property Value2: Boolean read FValue2 write FValue2;
end;
</pre>
<p>Затем, в вашем новом компоненте, для этого подкласса необходимо создать ivar. Чтобы все работало правильно, вам необходимо перекрыть конструктор.</p>
<pre>
TMyPanel = class(TCustomPanel)
  private
    FBoolList: TBoolList;
  public
    constructor Create( AOwner: TComponent ); override;
  published
    property BoolList: TBoolList read FBoolList write FBoolLisr;
end;
</pre>
<p>Затем добавьте следующий код в ваш конструктор:</p>
<pre>
constructor TMyPanel.Create( AOwner: TComponent );
begin
  inherited Create( AOwner );
  FBoolList := TBoolList.Create;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
