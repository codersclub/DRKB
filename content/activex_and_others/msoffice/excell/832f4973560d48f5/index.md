---
Title: Как создать DLL для MS Excel?
Date: 01.01.2007
---


Как создать DLL для MS Excel?
=============================

::: {.date}
01.01.2007
:::

Problem/Question/Abstract:

How do I make delphi functions available to Excel users?

I have seen many articles telling how to control Excel from within
Delphi. However, it is also appealing to give Excel users (which tend to
be far less programming oriented guys) the power of tools built with
Dephi, its flexibility and velocity.

Answer:

The idea is very simple and is based upon the variable types that are
common to Excel\'s VBA and to Delphi. Those include 32 bit integer,
double precision floating point and, mainly, Excel ranges.

I found that Excel sometimes interprets incorrectly simple types when
passed by reference and thus I limmited their usage to value parameters.

On the other hand, ranges can only be passed by reference and can be
read from but not written to. This means that, within Delphi, you must
use the reserved word CONST instead of VAR.

First, I defined within a simple unit a set of functions that convert
simple Variant types to simple types and viceversa. Those are
IntToVar,Double and VarTodouble (the real unit also includes a StrToVar
function but not a VarToStr since this one is already included in the
System unit), and are used within the procedures that do the real work
(RangeToMatrix, RangeToVector,VectorToMatrix and VectortoRange).

All these functions (along with some others that you might find useful)
are put together in a unit called \"\_Variants\" whose source code is
copied here (with some slight modifications).

In the real unit you will find that there fucntions that provide
conversion between Excel ranges and SDL delphi component suite which I
have found to be quite useful (refer to www.lohninger.com).

I shall restrict the examples, however to standard types.

Lets take first a simple function:

This function, called gamma\_alfa, takes as input the mean and the
variance of a population and returns the alfa parameter of a gamma
distribution.

In Excel\'s VBA it is declared as

Declare Function gamma\_alfa Lib
\"c:\\archivos\\del\_files\\f\_auxiliares\_delphi\" Alias
\"gamma\_alfa\_XL\" (ByVal media As Double, ByVal varianza As Double) As
Double

note the lib statement that refers to name that the DLL actually has.

note also the ByVal modifiers used for declaring the variables as well
as the \"as double\" statements.

These mean that both the input and the output will be simple types of
type double.

In Delphi, the function is declared as

function gamma\_alfa(media, varianza : double) : Double;stdcall;

Note the stdcall at the end of the declaration. This is to ensure that
Delphi will use the Microsoft calling convention

Also note the inconsistency between the delphi function\'s name and the
\"alias\" statement in VBA.

This is set in the export clause of the DLL:

    exports ..., 
            gamma_alfa     name 'gamma_alfa_XL', 
            ...; 

Although irrelevant, the implementation of the function follows:

    implementation
     
    function gamma_alfa(media, varianza: double): Double; stdcall;
    begin
      gamma_alfa := media * media / varianza;
    end;

Now, let\'s go to the tough stuff: sending Excel ranges as parameters.

Now, I will make use of a function that gets and returns excel ranges as
parameters:

This function is called gamma\_parametros and takes as input an
histogram (with frequencies and class markers) and returns the alfa and
beta parameters for a gamma. Here is its VBA declaration:

Declare Function gamma\_parametros Lib
\"c:\\archivos\\del\_files\\f\_auxiliares\_delphi\" Alias
\"gamma\_parametros\_XL\" (ByRef marcas\_de\_clase As Variant, ByRef
frecuencias As Variant) As Variant

Now note hte \"Byref\" and the as \"Variant\" types.

In Delphi, the function is declared as follows:

function gamma\_parametros\_XL(const \_marcas\_de\_clase, \_frecuencias:
Variant): Variant;

stdcall;

and is implemented as:

    function gamma_parametros_XL(const _marcas_de_clase, _frecuencias: Variant): Variant;
      stdcall;
    var
      marcas_de_clase, frecuencias, pars: TVector_;
      pars_: Variant;
    begin
      RangeToVector(_marcas_de_clase, marcas_de_clase);
      RangeToVector(_frecuencias, frecuencias);
      pars := gamma_parametros(marcas_de_clase, frecuencias);
      VectorToRange(pars, pars_);
      gamma_parametros_XL := pars_;
    end;

Note that the functions that does the real work is not
gamma\_parametros\_XL but gamma\_parametros. The former only does the
job of converting Excel ranges to TVector\_ and viceversa.

the exports clause exports gamma\_parametros\_XL, since it\'s the one
that is replicated in the VBA definition, and thus it does not need a
\'name\' clause.

Here is the implementation of the gamma\_parametros function:

    function gamma_parametros(const marcas_de_clase, frecuencias: TVector_): TVector_;
    var
      pars: TVector_;
      mu, sigmac: double;
    begin
      SetLength(pars, 2);
      mu := media_ponderada(marcas_de_clase, frecuencias);
      sigmac := varianza_ponderada(marcas_de_clase, frecuencias);
      pars[0] := gamma_alfa(mu, sigmac);
      pars[1] := gamma_beta(mu, sigmac);
      gamma_parametros := pars;
    end;

Here is the listing of the \_Variants unit:

    interface
    uses SysUtils,
      excel97,
      vector,
      matrix,
      Classes,
      Dialogs,
      registry,
      windows;
     
    type
     
      tmatriz = array of array of double;
      tvector_ = array of double;
     
    function IntToVar(dato: longint): variant;
    function DoubleToVar(dato: double): variant;
     
    function VarToDouble(const dato: variant): double;
     
    procedure RangeToMatrix(const rango: variant; var matriz: tmatriz);
    procedure RangeToVector(const rango: variant; var matriz: tvector_);
    procedure MatrixToRange(const matriz: tmatriz; var rango: variant);
    procedure VectorToRange(const matriz: tvector_; var rango: variant);
     
    procedure transpose(var matriz: tmatriz);
     
    implementation
     
    function IntToVar(dato: longint): variant;
    var
      temp: variant;
    begin
      tvardata(temp).vtype := VarInteger;
      tvardata(temp).Vinteger := dato;
      IntToVar := temp;
    end;
     
    function DoubleToVar(dato: double): variant;
    var
      temp: variant;
    begin
      tvardata(temp).vtype := VarDouble;
      tvardata(temp).VDouble := dato;
      DoubleToVar := temp;
    end;
     
    function VarToDouble(const dato: variant): double;
    var
      temp: variant;
    begin
      try
        temp := varastype(dato, vardouble);
      except
        on EVariantError do
        begin
          tvardata(temp).vtype := vardouble;
          tvardata(temp).vdouble := 0.0;
        end;
      end;
      VarToDouble := tvardata(temp).vdouble;
    end;
     
    procedure RangeToMatrix(const rango: variant; var matriz: tmatriz);
    var
      Rows, Columns: longint;
      i, j: longint;
    begin
      if ((tvardata(rango).vtype and vararray) = 0) and
        ((tvardata(rango).vtype and vartypemask) = vardispatch) then
      begin
        Rows := Rango.rows.count;
        Columns := Rango.columns.count;
        SetLength(matriz, Rows);
        for i := 0 to Rows - 1 do
          SetLength(matriz[i], Columns);
        for i := 0 to Rows - 1 do
          for J := 0 to Columns - 1 do
            matriz[i, j] := VarToDouble(Rango.cells[i + 1, j + 1]);
      end
      else if ((tvardata(rango).vtype and vararray) <> 0) then
      begin
        rows := vararrayhighbound(rango, 1) - vararraylowbound(rango, 1) + 1;
        if VarArrayDimCount(rango) = 2 then
        begin
          columns := vararrayhighbound(rango, 2) - vararraylowbound(rango, 2) + 1;
          setLength(matriz, rows);
          for i := 0 to Rows - 1 do
            SetLength(matriz[i], Columns);
          for i := 0 to Rows - 1 do
            for J := 0 to Columns - 1 do
              matriz[i, j] := vartodouble(rango[i + 1, j + 1]);
        end
        else
        begin
          setlength(matriz, 1);
          setlength(matriz[0], rows);
          for i := 0 to rows - 1 do
            matriz[0, i] := vartodouble(rango[i + 1]);
        end;
      end
      else
      begin
        rows := 1;
        columns := 1;
        setLength(matriz, rows);
        setLength(matriz[0], columns);
        matriz[0, 0] := vartodouble(rango);
      end
    end;
     
    procedure RangeToVector(const rango: variant; var matriz: tvector_);
    var
      Rows, columns: longint;
      i, j: longint;
    begin
      if ((tvardata(rango).vtype and vararray) = 0) and
        ((tvardata(rango).vtype and vartypemask) = vardispatch) then
      begin
        Rows := Rango.count;
        SetLength(matriz, Rows);
        for i := 0 to Rows - 1 do
          matriz[i] := VarToDouble(Rango.cells[i + 1]);
      end
      else if ((tvardata(rango).vtype and vararray) <> 0) then
      begin
        rows := vararrayhighbound(rango, 1) - vararraylowbound(rango, 1) + 1;
        if VarArrayDimCount(rango) = 1 then
        begin
          setLength(matriz, rows);
          for i := 0 to rows - 1 do
            matriz[i] := vartodouble(rango[i + 1]);
        end
        else
        begin
          columns := vararrayhighbound(rango, 2) - vararraylowbound(rango, 2) + 1;
          setlength(Matriz, Columns * Rows);
          for i := 1 to rows do
            for j := 1 to columns do
            try
              matriz[(i - 1) * columns + j] := VarToDouble(rango[i, j]);
            except
              on EVariantError do
                matriz[(i - 1) * columns + j] := 0;
            end;
        end
      end
      else
      begin
        rows := 1;
        setLength(matriz, rows);
        matriz[0] := vartodouble(rango);
      end;
    end;
     
    procedure MatrixToRange(const matriz: tmatriz; var rango: variant);
    var
      Rows, Columns: longint;
      i, j: longint;
    begin
      Rows := high(matriz) - low(matriz) + 1;
      Columns := high(matriz[0]) - low(matriz[0]) + 1;
      rango := VarArrayCreate([1, Rows, 1, Columns], varDouble);
      for i := 1 to Rows do
        for j := 1 to Columns do
          rango[i, j] := matriz[i - 1, j - 1];
    end;
     
    procedure VectorToRange(const matriz: tvector_; var rango: variant);
    var
      Rows: longint;
      i: longint;
    begin
      Rows := high(matriz) - low(matriz) + 1;
      rango := VarArrayCreate([1, Rows], varDouble);
      for i := 1 to Rows do
        rango[i] := matriz[i - 1];
    end;
     
    procedure transpose(var matriz: tmatriz);
    var
      Rows, Columns,
        i, j: longint;
      temp: double;
    begin
      Rows := high(matriz) - low(matriz) + 1;
      Columns := high(matriz[0]) - low(matriz[0]) + 1;
      for i := 0 to rows - 1 do
        for j := i to columns - 1 do
        begin
          temp := matriz[i, j];
          matriz[i, j] := matriz[j, i];
          matriz[j, i] := temp;
        end;
    end;
     
    end.

One final warning note:

Notice that the types\' names in VBA are NOT the same as in Delphi.

The two must obvious are BOOLEAN (which in VBA is a 2 byte type whereas
in Delphi is a one byte type). Thus you MUST use WORDBOOL in Delphi.

The other obvious type is INTEGER (in DElphi is a 4-byte type and in VBA
a 2-byte type). To avoid confussion use LONGINT in Delphi and LONG in
VBA

I will be more than glad to send you the full source code of the
\_Variant unit

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
