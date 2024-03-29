---
Title: Модуль реализации матричных вычислений для массивов больших размеров
Author: Andrey
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Модуль реализации матричных вычислений для массивов больших размеров
====================================================================

В этом модуле «осели» все операции с матрицами и векторами, которые я
использовал для работы. Но есть алгоритмы, которые многие, наверняка,
увидят впервые: Divide - алгоритм прямого деления, MSqrt - квадратный
корень, MAbs - абсолютная величина. Поскольку модуль содержит все, от
элементарных операций до матричных, разобраться будет несложно:

Например, решение системы ЛУ (консольное приложение)

    var
      N : Integer;
      A : Matrix;
      b, x : Vector;
    begin
      N := . . .;
      A.Init( N, N );
      b.Init( N );
      x.Init( N ); // или x.Init( B ); или x.InitRow( A );
      . . .
      { формирование A и b }
      . . .
      x.Divide( b, A );
      x.Print;
      . . .
    end.

Некоторые алгоритмы требуют пояснения, например функции для вычисления адреса элемента
матрицы/вектора:

    Matrix.E( i, j : LongWord )
    Vector.E( i : Integer ) : RealPtr : (RealPtr = ^Real)

Перешли из ДОС, когда в модуле использовался алгоритм
управления виртуальной памятью для больших размерностей.

    Matrix.Multiple( X, Y : Vector )

\- Результатом которого является произведение вектора X на
транспонированный вектор Y - матрица ранга 1.

    Matrix.Invert( A : Matrix )

\- если A[N,M\], и N \<\> M, то результат - матрица размера [M,N] -
псевдообратная = A+.

    Matrix.Addition( A : Matrix; B : Real )

\- добавление числа в главную диагональ.

    Matrix.Diag( r : Real )

\- присваивание значения главной диагонали.


    unit HMatrixW;
    {
            Матричная алгебра 1996-1998,
            HNV 1996 .
    }
    interface
    uses
       SysUtils,
       HNVString,
       Math,
       // VHeapLow,
       Windows,
       Dialogs;
     
    const
       MaxRow = 214748364; { Максимальное к-во элементов в векторе }
     
       NumbSpline : LongWord = 1;
       Indicator : Word = $118F;
       Condition : Boolean = True;
       InitCount : Integer = 0;
       InitSize : Integer = 0;
     
    var
       NIteration : LongWord; { Число итераций процесса }
     
       Temp : Real;
       MathEps : Real; { Относительная машинная точность         }
       SqrtEps : Real; { и корень из нее                         }
     
       Eps : Real;
       MinEps : Real;
     
    type
     
       VirtualPtr =
          record
          Ptr : Pointer;
          Size : LongWord;
       end;
     
       RealPtr =
          ^Real;
     
       ArrayType =
          array[ 1..1 ] of real;
     
       ArrayPtr =
          ^ArrayType;
     
       VectorPrim = { Вектор }
       object
          VAddr : VirtualPtr; { Виртуальный адрес  (tail of DOS)  }
          FInit : Word; { Флаг инициализации (tail of DOS)  }
          n : LongWord; { Размерность вектора  }
          function Addr : ArrayPtr; { Адрес начала вектора }
          function E( I : LongWord ) : RealPtr; { Адрес элемента }
          {                                       _ }
          procedure Copy( X : VectorPrim ); {   = X }
          {                                          _   _ }
          procedure Substrac( X, Y : VectorPrim ); { X - Y }
          {                                          _   _ }
          procedure Addition( X, Y : VectorPrim ); { X + Y }
          procedure Init( Size : LongWord ); overload;
          procedure Init( X : VectorPrim ); overload;
          procedure Free;
          function Summ : Real; { Сумма элементов вектора   }
          function SummSqr : Real; { Сумма квадратов элементов }
     
          procedure Sort( a1 : VectorPrim ); { Сортировка вектора по возрастанию }
          procedure SortAbs( a1 : VectorPrim ); { -<>- по модулю                }
          procedure SortBy( a1 : VectorPrim ); { Сортировка вектора по возрастанию }
          procedure Clear; { Очистить нулями }
          procedure Print;
          procedure PrintF( M : Byte );
          procedure ScMultiple( X : Real; y : VectorPrim ); { Умножение на скаляр }
          procedure ScDivide( X : Real; y : VectorPrim ); { Деление на скаляр }
          procedure SetAll( X : Real ); { Все эл-ты = X }
          procedure Multiple( x, y : VectorPrim ); overload; { поэлементное умножение }
       end;
     
       MatrixPrimArray =
          array[ 1..1 ] of VectorPrim;
     
       MatrixVPrimPtr =
          ^MatrixPrimArray;
     
       Matrix = { Матрица }
       object
          VAddr : VirtualPtr; { Виртуальный адрес массива векторов
          матрица хранится по строкам. Максималь-
          ная размерность MaxRow * MaxRow (tail of DOS)}
          FInit : Word; { Флаг инициализации (tail of DOS) }
          n, m : LongWord; { Размерности матрицы }
          function Addr : MatrixVPrimPtr; { Адрес массива векторов-строк }
          function E( i, j : LongWord ) : RealPtr; { Адрес элемента }
          procedure Copy( B : Matrix ); {   = B }
          procedure Multiple( A, B : Matrix ); overload; { A * B }
          procedure Multiple( A, B : VectorPrim ); overload;
          procedure Substrac( A, B : Matrix ); { A - B }
          procedure Addition( A, B : Matrix ); overload; { A + B }
          procedure Addition( A : Matrix; B : VectorPrim ); overload;
          procedure Addition( A : Matrix; B : Real ); overload;
          procedure Divide( Bx, Ax : Matrix ); { B / A }
          procedure Diag( B : VectorPrim ); overload; { Diag = b    }
          procedure Diag( r : Real ); overload; { Diag(*) = r    }
          procedure Col( i : LongWord; B : VectorPrim ); overload; { Столбец = b }
          procedure Row( i : LongWord; B : VectorPrim ); overload; { Строка = b  }
          procedure Col( i : LongWord; r : Real ); overload; { Столбец = r }
          procedure Row( i : LongWord; r : Real ); overload; { Строка = r  }
          procedure Clear; { Обнуление эл-тов }
          procedure Invert( A : Matrix ); { Вычисление обратной/псевдообратной матрицы }
          procedure Print;
          procedure PrintF( M2 : Byte ); { M2 - к-во знач. цифр }
          procedure ScMultiple( X : Real; Y : Matrix ); { умножение на скаляр }
          procedure Trans( A : Matrix ); { Транспонирование }
          procedure MSqrt( AX : Matrix ); { Вычисление корня для              }
          {                                 положительно-определенной матрицы }
          procedure MAbs( AX : Matrix ); { Матричная функция ABS }
          function Cond : Real; { числo обусловленности (1-Ok)}
          function Norm : Real; { Норма матрицы }
          function Alpha : Real; { Параметр регуляризации }
          procedure Init( Size1, Size2 : LongWord ); overload; { Размещение матрицы }
          procedure Init( A : Matrix ); overload;
          procedure InitTrans( A : Matrix );
          procedure InitSqr( A : Matrix );
          procedure ReadFromFile( FN : string ); { Читать из файла TXT,
          Init не требуется }
          procedure MSqr( A : Matrix ); { = Trans( A ) * A }
          procedure Simmetry( A : Matrix ); { = ( Trans( A ) + A ) / 2 }
          function Asimm : Real; { Ассимметрия матрицы }
          function Difference( A : Matrix ) : Real;
          procedure Free; { Освобождение памяти }
       end;
     
       Vector =
          object( VectorPrim )
          procedure Divide( x : Vector; AB : Matrix ); overload; { =x / AB }
          procedure Divide( x, y : Vector ); overload;
          procedure Multiple( A : Matrix; x : Vector ); overload; { =A * x  }
          procedure Diag( A : Matrix ); { =Диаголаль }
          procedure Col( i : LongWord; A : Matrix ); { =Столбец }
          procedure Row( i : LongWord; A : Matrix ); { =Строка }
          function Max : Real; { Максимальный элемент }
          function Min : Real; { Минимальный элемент  }
          procedure Abs( x : Vector ); { Абсолютная величина  }
          function MinIndex : LongWord; { Индекс мин.эл-та     }
          function MaxIndex : LongWord; { Индекс макс. эл-та   }
          function Poly( x : Real ) : Real; { Полином x }
          procedure IntPower( x : Vector; P : Integer ); { Целая степенть(поэлементно) }
          procedure SubVector( x : Vector; From, Count : LongWord );
          procedure InitRow( A : Matrix ); overload;
          procedure InitRow( i : Integer; A : Matrix ); overload;
          procedure InitCol( A : Matrix ); overload;
          procedure InitCol( i : Integer; A : Matrix ); overload;
          procedure FillBodyTo( XMax : Real );
          procedure FillBody;
          function Difference( x : Vector ) : Real;
          procedure TableDiff( x, y : Vector ); // Две программы из
          procedure Smoothe( y : Vector ); // Фортран-пакета(старые)
       end;
     
       SplineCoeffType =
          record
          NPoint : LongWord;
          h, d, bb, d1, dg, d2 : Vector;
       end;
     
       SplineCoeffPtr =
          ^SplineCoeffType;
     
       Spline = { Кубические сплайны }
       object
          VAddr : VirtualPtr;
          function Addr : SplineCoeffPtr;
          procedure Init( X, Y : Vector );
          function F( X : Real ) : Real; { Значение сплайна в точке X }
          function Integral( A, B : Real ) : Real; overload; { Интеграл от А до В  }
          function Integral : Real; overload; { Интеграл  }
          function FMin( A, B : Real ) : Real;
          function FMax( A, B : Real ) : Real;
          function ZeroIn( A, B : Real ) : Real;
          function DF( X : Real ) : Real; { Значение первой производной }
          procedure Free;
       private
          function Integr( A, B : Real ) : Real; { Интеграл от А до В  }
       end;
     
       PolyApprox = { Аппроксимация полиномом }
       object
          Coeff : Vector;
          dCoeff : Vector;
          PlanM : Matrix;
          procedure Init( xt, yt : Vector; NP : Integer );
          function PX( xr : Real ) : Real;
          function DPX( xr : Real ) : Real;
          procedure Free;
       private
          XMin, XMax : Real;
       end;
     
       Eigen = { Собственные значения ( для симметричных матриц ) }
       object
       private
          function F( Alpha : Real ) : Real;
       public
          Values : Vector;
          Vectors : Matrix;
          AbsValues : Vector;
          Cond : Real;
          D, R, P : Matrix; { D, R и P - факторы : D = R * R; A = D + R + P; }
          Gamma : Matrix; { Матрица ошибок извлеч. из A }
          procedure Init( A : Matrix );
          procedure Free;
       end;
     
       {*--------------------------------------------------------------------*}
     
    implementation
    uses
       HMinZero; // одномерный поиск
     
    procedure Error( E : Word );
    begin
       ShowMessage( 'Internal Erorr : ' + IntToStr( E ) );
       Halt( E );
    end;
     
    procedure GetMem( var P : Pointer; Size : Integer ); { (tail of DOS) }
    begin
       Inc( InitSize, Size );
       Inc( InitCount );
       System.GetMem( P, Size );
    end;
     
    procedure FreeMem( P : Pointer; Size : Integer ); { (tail of DOS) }
    begin
       Dec( InitSize, Size );
       Dec( InitCount );
       System.FreeMem( P, Size );
    end;
     
    procedure Vector.TableDiff( x, y : Vector );
    {
    C        SUBROUTINE DDGT3
    C
    C        PURPOSE
    C           TO COMPUTE A VECTOR OF DERIVATIVE VALUES GIVEN VECTORS OF
    C           ARGUMENT VALUES AND CORRESPONDING FUNCTION VALUES.
    C
    C        USAGE
    C           CALL DDGT3(X,Y,Z,NDIM,IER)
    C
    C        DESCRIPTION OF PARAMETERS
    C           X     -  GIVEN VECTOR OF DOUBLE PRECISION ARGUMENT VALUES
    C                    (DIMENSION NDIM)
    C           Y     -  GIVEN VECTOR OF DOUBLE PRECISION FUNCTION VALUES
    C                    CORRESPONDING TO X (DIMENSION NDIM)
    C           Z     -  RESULTING VECTOR OF DOUBLE PRECISION DERIVATIVE
    C                    VALUES (DIMENSION NDIM)
    C           NDIM  -  DIMENSION OF VECTORS X,Y AND Z
    C           IER   -  RESULTING ERROR PARAMETER
    C                    IER  = -1  - NDIM IS LESS THAN 3
    C                    IER  =  0  - NO ERROR
    C                    IER POSITIVE  - X(IER) = X(IER-1) OR X(IER) =
    C                                    X(IER-2)
    C
    C        REMARKS
    C           (1)   IF IER = -1,2,3, THEN THERE IS NO COMPUTATION.
    C           (2)   IF IER =  4,...,N, THEN THE DERIVATIVE VALUES Z(1)
    C                ,..., Z(IER-1) HAVE BEEN COMPUTED.
    C           (3)   Z CAN HAVE THE SAME STORAGE ALLOCATION AS X OR Y.  IF
    C                 X OR Y IS DISTINCT FROM Z, THEN IT IS NOT DESTROYED.
    C
    C        SUBROUTINES AND FUNCTION SUBPROGRAMS REQUIRED
    C           NONE
    C
    C        METHOD
    C           EXCEPT AT THE ENDPOINTS X(1) AND X(NDIM), Z(I) IS THE
    C           DERIVATIVE AT X(I) OF THE LAGRANGIAN INTERPOLATION
    C           POLYNOMIAL OF DEGREE 2 RELEVANT TO THE 3 SUCCESSIVE POINTS
    C           (X(I+K),Y(I+K)) K = -1,0,1. (SEE HILDEBRAND, F.B.,
    C           INTRODUCTION TO NUMERICAL ANALYSIS, MC GRAW-HILL, NEW YORK/
    C           TORONTO/LONDON, 1956, PP. 64-68.)
    C
    C     ..................................................................
    C
          SUBROUTINE DDGT3(X,Y,Z,NDIM,IER)}
    var
       DY1, DY2, DY3, A, B : Real;
       i : Integer;
    begin
       { TEST OF DIMENSION AND ERROR EXIT IN CASE NDIM IS LESS THAN 3}
       if x.n <> y.n then
          Error( 8001 );
       { PREPARE DIFFERENTIATION LOOP}
       A := X.e( 1 )^;
       B := Y.e( 1 )^;
       I := 2;
       DY2 := X.e( 2 )^ - A;
       if DY2 = 0 then
          Error( 8002 );
     
       DY2 := ( Y.e( 2 )^ - B ) / DY2;
       { START DIFFERENTIATION LOOP}
       for I := 3 to x.n do
          begin
             A := X.e( I )^ - A;
             if A = 0 then
                Error( 8002 );
             A := ( Y.e( I )^ - B ) / A;
             B := X.e( I )^ - X.e( I - 1 )^;
             if B = 0 then
                Error( 8002 );
             DY1 := DY2;
             DY2 := ( Y.e( I )^ - Y.e( I - 1 )^ ) / B;
             DY3 := A;
             A := X.e( I - 1 )^;
             B := Y.e( I - 1 )^;
     
             if ( I - 3 ) <= 0 then
                e( 1 )^ := DY1 + DY3 - DY2;
             e( I - 1 )^ := DY1 + DY2 - DY3;
          end;
     
       e( n )^ := DY2 + DY3 - DY1;
     
    end;
     
    procedure Vector.Smoothe( y : Vector );
    {
    C        SUBROUTINE DSE15
    C
    C        PURPOSE
    C           TO COMPUTE A VECTOR OF SMOOTHED FUNCTION VALUES GIVEN A
    C           VECTOR OF FUNCTION VALUES WHOSE ENTRIES CORRESPOND TO
    C           EQUIDISTANTLY SPACED ARGUMENT VALUES.
    C
    C        USAGE
    C           CALL DSE15(Y,Z,NDIM,IER)
    C
    C        DESCRIPTION OF PARAMETERS
    C           Y     -  GIVEN VECTOR OF DOUBLE PRECISION FUNCTION VALUES
    C                    (DIMENSION NDIM)
    C           Z     -  RESULTING VECTOR OF DOUBLE PRECISION SMOOTHED
    C                    FUNCTION VALUES (DIMENSION NDIM)
    C           NDIM  -  DIMENSION OF VECTORS Y AND Z
    C           IER   -  RESULTING ERROR PARAMETER
    C                    IER = -1  - NDIM IS LESS THAN 5
    C                    IER =  0  - NO ERROR
    C
    C        REMARKS
    C           (1)  IF IER=-1 THERE HAS BEEN NO COMPUTATION.
    C           (2)   Z CAN HAVE THE SAME STORAGE ALLOCATION AS Y.  IF Y IS
    C                 DISTINCT FROM Z, THEN IT IS NOT DESTROYED.
    C
    C        SUBROUTINE AND FUNCTION SUBPROGRAMS REQUIRED
    C           NONE
    C
    C        METHOD
    C           IF X IS THE (SUPPRESSED) VECTOR OF ARGUMENT VALUES, THEN
    C           EXCEPT AT THE POINTS X(1),X(2),X(NDIM-1) AND X(NDIM), EACH
    C           SMOOTHED VALUE Z(I) IS OBTAINED BY EVALUATING AT X(I) THE
    C           LEAST-SQUARES POLYNOMIAL OF DEGREE 1 RELEVANT TO THE 5
    C           SUCCESSIVE POINTS (X(I+K),Y(I+K)) K = -2,-1,...,2.  (SEE
    C           HILDEBRAND, F.B., INTRODUCTION TO NUMERICAL ANALYSIS,
    C           MC GRAW-HILL, NEW YORK/TORONTO/LONDON, 1956, PP. 295-302.)
    C
    C     ..................................................................
    C
          SUBROUTINE DSE15(Y,Z,NDIM,IER)
    }
    var
       A, B, C : Real;
       I, NDIM : Integer;
    begin
       {        TEST OF DIMENSION }
       NDIM := y.n;
     
       if ( NDIM < 5 ) then
          Error( 8004 );
     
       { PREPARE LOOP }
       A := Y.e( 1 )^ + Y.e( 1 )^;
       C := Y.e( 2 )^ + Y.e( 2 )^;
       B := 0.2 * ( A + Y.e( 1 )^ + C + Y.e( 3 )^ - Y.e( 5 )^ );
       C := 0.1 * ( A + A + C + Y.e( 2 )^ + Y.e( 3 )^ + Y.e( 3 )^ + Y.e( 4 )^ );
       { START LOOP }
       for I := 5 to NDIM do
          begin
             A := B;
             B := C;
             C := 0.2E0 * ( Y.e( I - 4 )^ + Y.e( I - 3 )^ + Y.e( I - 2 )^
                + Y.e( I - 1 )^ + Y.e( I )^ );
             e( I - 4 )^ := A;
          end;
       { UPDATE LAST FOUR COMPONENTS}
       A := Y.e( NDIM )^ + Y.e( NDIM )^;
       A := 0.10 * ( A + A + Y.e( NDIM - 1 )^ + Y.e( NDIM - 1 )^
          + Y.e( NDIM - 1 )^ + Y.e( NDIM - 2 )^ + Y.e( NDIM - 2 )^
          + Y.e( NDIM - 3 )^ );
       e( NDIM - 3 )^ := B;
       e( NDIM - 2 )^ := C;
       e( NDIM - 1 )^ := A;
       e( NDIM )^ := A + A - C;
    end;
     
    procedure Jacobi( AT, S : Matrix; L : Vector );
    var
       i, j, k, p, q : Word;
     
       SinT, CosT, Sin2T, Cos2T,
          Lambda, Mu, Omega,
          AMax, App, Aqq, Apq, Temp : Real;
     
       T : Vector;
       A, B, R : Matrix;
     
    begin
       A.Init( AT );
       B.Init( A );
     
       S.Clear;
       for i := 1 to S.n do
          S.E( i, i )^ := 1;
     
       R.Init( S );
       T.InitRow( R );
     
       NIteration := 0;
     
       repeat
     
          Inc( NIteration );
     
          B.Copy( A );
          R.Copy( S );
     
          p := 1;
          q := 2;
          AMax := A.E( p, q )^;
     
          T.Diag( A );
          Temp := T.Max;
     
          for i := 1 to A.n do
             for j := i + 1 to A.n do
                if Abs( A.E( i, j )^ ) > AMax then
                   begin
                      p := i;
                      q := j;
                      AMax := Abs( A.E( p, q )^ );
                   end;
     
          if ( AMax + Temp ) = Temp then
             Break;
     
          App := A.E( p, p )^;
          Aqq := A.E( q, q )^;
          Apq := A.E( p, q )^;
     
          Lambda := -Apq;
          Mu := ( App - Aqq ) / 2.0;
          Omega := Lambda / Sqrt( Sqr( Lambda ) + Sqr( Mu ) );
     
          if Mu < 0 then
             Omega := -Omega;
     
          SinT := Omega / Sqrt( 2 * ( 1 + Sqrt( 1 - Sqr( Omega ) ) ) );
          Sin2T := Sqr( SinT );
          CosT := Sqrt( 1 - Sin2T );
          Cos2T := Sqr( CosT );
     
          for k := 1 to A.n do
             begin
                B.E( p, k )^ := A.E( p, k )^ * CosT - A.E( q, k )^ * SinT;
                B.E( q, k )^ := A.E( p, k )^ * SinT + A.E( q, k )^ * CosT;
             end;
     
          for i := 1 to A.n do
             begin
                B.E( i, p )^ := A.E( i, p )^ * CosT - A.E( i, q )^ * SinT;
                B.E( i, q )^ := A.E( i, p )^ * SinT + A.E( i, q )^ * CosT;
     
                R.E( i, p )^ := S.E( i, p )^ * CosT - S.E( i, q )^ * SinT;
                R.E( i, q )^ := S.E( i, p )^ * SinT + S.E( i, q )^ * CosT;
             end;
     
          B.E( p, p )^ := App * Cos2T + Aqq * Sin2T - 2 * Apq * SinT * CosT;
          B.E( q, q )^ := App * Sin2T + Aqq * Cos2T + 2 * Apq * SinT * CosT;
          B.E( p, q )^ := 0;
          B.E( q, p )^ := 0;
     
          A.Copy( B );
          S.Copy( R );
     
       until false;
     
       L.Diag( A );
     
       B.Free;
       R.Free;
       A.Free;
       T.Free;
     
    end;
     
    function Eigen.F( Alpha : Real ) : Real;
    var
       Q, T, X : Vector;
       St, S : Matrix;
       Z : Real;
    begin
       Inc( NIteration );
     
       S.Init( Gamma );
       St.InitTrans( Vectors );
       Q.InitRow( Gamma );
       T.Init( Q );
       X.Init( Q );
     
       S.Clear;
       S.Diag( Exp( Alpha ) );
     
       S.Multiple( Vectors, S );
       S.Multiple( S, St );
     
       T.Diag( Gamma );
       T.SetAll( 1 );
     
       Q.Multiple( Gamma, T );
     
       S.Addition( Gamma, S );
     
       X.Divide( Q, S );
     
       T.Substrac( X, T );
     
       Z := T.SummSqr;
     
       F := Ln( Z );
     
       Q.Free;
       T.Free;
       S.Free;
       ST.Free;
       X.Free;
     
    end;
     
    procedure Eigen.Init( A : Matrix );
    var
       Iter : LongWord;
       Q, T, X : Vector;
       St, S : Matrix;
       xZ : Real;
    begin
     
       if A.n <> A.m then { Матрица квадратная ? }
          Error( 4001 );
     
       if A.n < 2 then
          Error( 4003 );
     
       Values.InitRow( A );
       Vectors.Init( A );
     
       Jacobi( A, Vectors, Values );
       AbsValues.Init( Values );
       AbsValues.Abs( Values );
     
       if AbsValues.Min <> 0 then
          Cond := AbsValues.Max / AbsValues.Min
       else
          Cond := 1E+38;
     
       D.Init( A );
       R.Init( D );
       P.Init( R );
     
       Gamma.Init( A );
       Q.InitRow( A );
       X.Init( Q );
       T.Init( Q );
       St.Init( A );
       S.Init( St );
     
       Iter := NIteration;
     
       D.Clear;
       D.Diag( 1 );
       R.ScMultiple( 4, R );
       R.Addition( R, D );
       R.MSqrt( R );
       R.Substrac( R, D );
       R.ScMultiple( 0.5, R );
       D.MSqr( R );
       P.Substrac( A, R );
       P.Substrac( P, D );
     
       NIteration := Iter + NIteration;
     
       xZ := Exp( Ln( MathEps ) * ( Ln( 1 / MathEps ) / ( Ln( Cond ) + Ln( 1 / MathEps ) ) ) );
     
       Q.SetAll( Exp( xZ ) );
     
       S.Clear;
       S.Diag( Q );
     
       St.Trans( Vectors );
       S.Multiple( Vectors, S );
       S.Multiple( S, St );
     
       Gamma.Copy( S );
     
       Q.Free;
       T.Free;
       X.Free;
       St.Free;
       S.Free;
     
    end;
     
    procedure Vector.Divide( x, y : Vector );
    var
       i : LongWord;
    begin
       if x.n <> y.n then
          Error( 4010 );
       for i := 1 to x.n do
          E( i )^ := x.E( i )^ / y.E( i )^;
    end;
     
    procedure Eigen.Free;
    begin
       Values.Free;
       Vectors.Free;
       AbsValues.Free;
       D.Free;
       R.Free;
       P.Free;
       Gamma.Free;
    end;
     
    procedure Matrix.Simmetry( A : Matrix );
    var
       T : Matrix;
    begin
       if A.n <> A.m then
          Error( 5001 );
     
       if n <> A.n then
          Error( 5002 );
     
       T.InitTrans( A );
       T.Addition( T, A );
     
       ScMultiple( 0.5, T );
     
       T.Free;
    end;
     
    procedure Matrix.MAbs( AX : Matrix );
    var
       T : Matrix;
    begin
       T.InitSqr( AX );
       MSqrt( T );
       T.Free;
    end;
     
    function Spline.FMin( A, B : Real ) : Real;
    begin
       FMin := HMinZero.FMin( SELF, A, B );
    end;
     
    function Spline.FMax( A, B : Real ) : Real;
    begin
       FMax := HMinZero.FMax( SELF, A, B );
    end;
     
    function Spline.ZeroIn( A, B : Real ) : Real;
    begin
       ZeroIn := FZeroIn( SELF, A, B );
    end;
     
    function Spline.Integr( A, B : Real ) : Real;
     
    var
       x1, x3, x5, F1, F3, F5 : Real;
     
       function Int( x1, x3, x5, F1, F3, F5, Eps : Real ) : Real;
     
       var
          h1, h2, f2, f4, x2, x4, s1, s2, s3 : Real;
          q1, q2, st : Real;
     
       begin
          h1 := X3 - X1;
          h2 := h1 / 2.;
     
          x2 := ( X3 + X1 ) / 2.;
          x4 := ( X5 + X3 ) / 2.;
     
          f2 := F( x2 );
          f4 := F( x4 );
     
          {  Формула Симпсона }
          s1 := h1 * ( f1 + 4. * f2 + f3 ) / 6.;
          s2 := h1 * ( f3 + 4. * f4 + f5 ) / 6.;
     
          { Формула Ньютона-Коттеса 5-го порядка }
          s3 := h2 * 2. * ( 7. * f1 + 32. * f2 + 12. * f3 + 32. * f4 + 7. * f5 ) / 45.;
     
          { Условие окончания }
     
          st := h2 / Abs( B - A );
          q1 := Abs( s1 + s2 - s3 );
          q2 := 0.5 * Eps * Abs( s1 + s2 + s3 ) * st + Eps;
     
          if ( q1 > q2 ) and
             ( h2 > Eps + Abs( B - A ) * Eps ) then
             { Рекурсия - если точность плохая }
             Int := Int( x1, x2, x3, f1, f2, f3, Eps )
                + Int( x3, x4, x5, f3, f4, f5, Eps )
          else
     
             { За решения принять значение формулы 5-го порядка }
             Int := s3;
       end;
     
    begin
     
       Integr := 0;
     
       if A = B then
          exit;
     
       x1 := A;
       x3 := B - ( B - A ) * 0.5;
       x5 := B;
     
       F1 := F( x1 );
       F3 := F( x3 );
       F5 := F( x5 );
     
       Integr := Int( x1, x3, x5, F1, F3, F5, Eps );
     
    end;
     
    function Spline.Integral( A, B : Real ) : Real;
    begin
       Integral := Integr( A, B );
    end;
     
    function Spline.Integral : Real;
    begin
       Integral := Integr( Addr^.d1.e( 1 )^, Addr^.d1.e( Addr^.d1.n )^ );
    end;
     
    procedure Vector.FillBodyTo( XMax : Real );
    var
       x, S : Real;
       i : Integer;
    begin
       x := Addr^[ 1 ];
       S := ( XMax - x ) / ( n - 1 );
       for i := 1 to n do
          begin
             Addr^[ i ] := x;
             x := x + S;
          end;
    end;
     
    procedure Vector.FillBody;
    begin
       FillBodyTo( Addr^[ n ] );
    end;
     
    procedure Vector.SubVector( x : Vector; From, Count : LongWord );
    var
       i, j : LongWord;
    begin
       if ( n < Count ) or ( ( Count + From - 1 ) > x.n ) then
          Error( 2004 );
     
       if ( x.n < From ) then
          Error( 2005 );
     
       j := 0;
       for i := From to From + Count - 1 do
          begin
             Inc( j );
             Addr^[ j ] := x.e( i )^;
          end;
    end;
     
    procedure PolyApprox.Init( xt, yt : Vector; NP : Integer );
    {
       Аппроксимация зависимости Y( x )
       полиномом степени NP - 1
     
       Вход :
          X, Y;
    }
    var
       A : Matrix; { Матрица плана }
       AT : Matrix; { --//-- Транспонированная }
       B : Matrix;
       BY : Vector;
       t : Vector;
       i, j : LongWord;
       Z : Real;
     
    begin
       Coeff.Init( NP );
     
       A.Init( xt.n, Coeff.n );
       {
          Формирование матрицы плана
       }
       t.Init( xt.n );
     
       XMin := xt.Min;
       XMax := xt.Max;
     
       for i := 1 to Coeff.n do
          begin
             for j := 1 to xt.n do
                t.E( j )^ := xt.e( j )^;
     
             t.IntPower( t, i - 1 );
             A.Col( i, t );
          end;
     
       { Обычный метод НК }
       PlanM.Init( A ); // Запомним матрицу плана
       AT.InitTrans( A ); //
       B.InitSqr( A ); //  B = AT * A
       Coeff.Multiple( AT, yt ); // Coeff = AT * y
       Coeff.Divide( Coeff, B ); { Coeff = Coeff / B }
       { но, можно и так : }
       { вычисление псевдообратной матрицы }
       //   AT.Invert( A );
       //
       //   Coeff.Multiple( AT, yt ); // Coeff = A+ * yt
     
       if NP > 1 then
          begin
             dCoeff.Init( Coeff.n - 1 );
     
             for i := 2 to Coeff.n do
                dCoeff.e( i - 1 )^ := Coeff.e( i )^ * ( i - 1 );
          end;
     
       t.Free;
       A.Free;
       AT.Free;
     
    end;
     
    function PolyApprox.PX( xr : Real ) : Real;
    begin
       PX := Coeff.Poly( xr );
    end;
     
    function PolyApprox.DPX( xr : Real ) : Real;
    {
       Производная полинома в "xr"
    }
    begin
       DPX := dCoeff.Poly( xr );
    end;
     
    procedure PolyApprox.Free;
    begin
       if Coeff.n > 1 then
          dCoeff.Free;
     
       Coeff.Free;
       PlanM.Free;
    end;
     
    function Matrix.Difference( A : Matrix ) : Real;
    begin
       Difference := SELF.Norm - A.Norm;
    end;
     
    function Vector.Difference( x : Vector ) : Real;
    begin
       Difference := Sqrt( SELF.SummSqr ) - Sqrt( x.SummSqr );
    end;
     
    function Matrix.Asimm : Real;
    {
       Ассимметрия матрицы
    }
    var
       i, j : LongWord;
       S, T : Real;
    begin
     
       if N <> M then
          Error( 2002 );
     
       S := 0;
       T := S;
       for i := 1 to N do
          for j := 1 to N do
             if i <> j then
                begin
                   S := S + Math.IntPower( E( i, j )^ - E( j, i )^, 2 );
                   {               T := T + ( E(i,j)^ + E(j,i)^ ) / 2; }
                end;
     
       S := Sqrt( S ) {/ ( T + 1 )};
       Asimm := S;
     
    end;
     
    procedure Vector.IntPower( x : Vector; P : Integer );
    {
       Поэлементное возведение в целую степень
    }
    var
       i : LongWord;
       t : Vector;
    begin
       t.Init( x.N );
     
       for i := 1 to x.n do
          t.E( i )^ := Math.IntPower( x.E( i )^, P );
     
       Copy( t );
       t.Free;
    end;
     
    procedure Matrix.MSqr( A : Matrix );
    {     T
       = A  * A ( квадрат матрицы )
    }
    var
       T : Matrix;
     
    begin
       if ( N <> M ) or ( M <> A.M ) then
          Error( 2001 );
     
       T.InitTrans( A );
       Multiple( T, A );
     
       T.Free;
     
    end;
     
    procedure Matrix.InitSqr( A : Matrix );
    {     T
       = A  * A ( квадрат матрицы )
    }
    begin
       Init( A.m, A.m );
       MSqr( A );
    end;
     
    function Vector.Poly( x : Real ) : Real; { Полином x }
    {
       Poly = .e(1) + x * ( .e(2) + x * ( .e(3) + x * ( .e(4) + ...x * .e(n))...
    }
    var
       i : Integer;
       S : Real;
    begin
       S := e( n )^;
     
       for i := n - 1 downto 1 do
          S := e( i )^ + S * x;
     
       Poly := S;
    end;
     
    procedure Matrix.ReadFromFile( FN : string );
    {
       Чтение матрицы из текстового файла
       ( по строкам )
    }
    var
       f : Text;
       S : string;
       i, j : LongWord;
       Y : Matrix;
    const
       Delim : CharSet =
       [ ' ', ';', #9 ];
    begin
       if FileExists( FN ) then
          begin
             Assign( f, FN );
             Reset( f );
             n := 0;
             j := n;
     
             while not Eof( f ) do
                begin
                   ReadLn( f, S );
     
                   if ( Trim( S ) = '' ) then
                      Continue;
     
                   if ( S[ 1 ] = '''' ) then
                      Continue;
     
                   Inc( n );
                   m := WordCount( S, Delim );
     
                   if j = 0 then
                      j := m
                   else
                      if j <> m then
                         begin
                            ShowMessage( 'Error in input file.(1)' );
                            Halt;
                         end;
                end;
     
             Y.Init( n, m );
             Y.Clear;
             Reset( f );
             n := 0;
             while not Eof( f ) do
                begin
                   ReadLn( f, S );
     
                   if ( Trim( S ) = '' ) then
                      Continue;
     
                   if ( S[ 1 ] = '''' ) then
                      Continue;
     
                   Inc( n );
     
                   for i := 1 to WordCount( S, Delim ) do
                      Y.E( n, i )^ := StrToFloat( ExtractWord( i, S, Delim ) );
                end;
     
             Init( n, m );
             Copy( Y );
             Y.Free;
             Close( f );
          end
       else
          begin
             ShowMessage( 'File : "' + FN + '" - not found.' );
             Halt;
          end;
    end;
     
    function Vector.Max : Real;
    {
       Максимальный элемент вектора
    }
    var
       i : LongWord;
       P : ArrayPtr;
       X : Real;
    begin
       P := Addr;
       X := P^[ 1 ];
     
       for i := 1 to n do
          if P^[ i ] > X then
             X := P^[ i ];
     
       Max := X;
    end;
     
    function Vector.Min : Real;
    {
       Минимальный элемент вектора
    }
    var
       i : LongWord;
       P : ArrayPtr;
       X : Real;
    begin
       P := Addr;
     
       X := P^[ 1 ];
     
       for i := 1 to n do
          if P^[ i ] < X then
             X := P^[ i ];
     
       Min := X;
    end;
     
    procedure Vector.Abs( x : Vector );
    {
       .e(i)^ = Abs( x.e(i)^ )
    }
    var
       i : LongWord;
       P1 : ArrayPtr;
       P2 : ArrayPtr;
    begin
       P1 := Addr;
       P2 := x.Addr;
     
       for i := 1 to n do
          P1^[ i ] := System.Abs( P2^[ i ] );
     
    end;
     
    function Vector.MaxIndex : LongWord;
    {
       Индекс максимального элемента
    }
    var
       i : LongWord;
       j : LongWord;
       P : ArrayPtr;
       X : Real;
    begin
       P := Addr;
       X := P^[ 1 ];
       j := 1;
     
       for i := 1 to n do
          if P^[ i ] > X then
             begin
                X := P^[ i ];
                j := i;
             end;
     
       MaxIndex := j;
    end;
     
    function Vector.MinIndex : LongWord;
    {
       Индекс минимального элемента
    }
    var
       i : LongWord;
       j : LongWord;
       P : ArrayPtr;
       X : Real;
    begin
       P := Addr;
       X := P^[ 1 ];
       j := 1;
     
       for i := 1 to n do
          if P^[ i ] < X then
             begin
                X := P^[ i ];
                j := i;
             end;
     
       MinIndex := j;
    end;
     
    function Matrix.Cond : Real;
    {
       Число обусловленности матрицы( произведение нормы обратной и нормы исходной )
                  -1
       Cond = ||.|| * ||.||.
    }
    var
       B, A : Matrix;
       n0, n1 : Real;
    begin
       n0 := SELF.Norm;
     
       if n = m then
          begin
             B.Init( SELF );
             A.Init( B );
             B.Clear;
             B.Diag( 1 );
             B.Divide( B, A );
          end
       else
          Error( 1011 );
     
       n1 := B.Norm;
     
       Cond := n1 * n0;
     
       B.Free;
       A.Free;
     
    end;
     
    function Matrix.Norm : Real;
    {
       Норма Фробениуса :
       = Sqrt( Summ( Sqr( .e( *, * ) ) ) )
    }
    var
       i : Integer;
       S : Real;
    begin
       S := 0;
     
       for i := 1 to n do
          S := S + Addr^[ i ].SummSqr;
     
       Norm := Sqrt( S );
    end;
     
    procedure Matrix.MSqrt( AX : Matrix );
    {
       HNV 1997
     
       Квадратный корень матрицы A.
       ( предполагается, что матрица A -
         положительно определенная. )
     
       R такая, что   T
                     R * R = A
     
       Симметричное/асимметричное разложение матрицы.
       Ассиметрия характерна для плохо обусловленных.
     
    }
    var
       Y, X, R, T : Matrix;
       Diff, DiffOld : Real;
       Alphax, EAlpha : Real;
       Reject : Boolean;
     
    begin
     
       Y.Init( n, n );
       T.Init( Y );
       X.Init( T );
       R.Init( X );
     
       X.ScMultiple( 0.5, AX );
       X.Addition( X, 1 ); { B = AX / 2 + 1 }
     
       NIteration := 0;
     
       Y.MSqr( X );
       Y.Substrac( Y, AX );
       DiffOld := Y.Norm;
     
       Alphax := 0.5;
       { Обычная реализация метода Ньютона }
       repeat
          Inc( NIteration );
     
          Y.MSqr( X );
          Y.Substrac( Y, AX );
     
          T.Trans( X );
          Y.Divide( Y, T );
     
          repeat
             T.ScMultiple( Alphax, Y );
             R.Substrac( X, T );
     
             T.MSqr( R );
             T.Substrac( T, AX );
     
             Diff := T.Norm;
     
             Reject := Diff > DiffOld;
     
             if Reject then
                Alphax := -Alphax / 17
             else
                Break;
     
             EAlpha := Alphax * Alphax + 1;
          until EAlpha = 1;
     
          if ( not Reject ) and
             ( Abs( Alphax ) * ( DiffOld - Diff ) > ( DiffOld + 1 ) * Eps ) then
             begin
                X.Copy( R );
                DiffOld := Diff;
                if Abs( Alphax ) < 0.5 then
                   Alphax := Alphax * 2;
             end
          else
             Break;
     
       until NIteration > 1023; // Обычно сходится за 20-30 итераций...
     
       Trans( X ); // - результат
     
       Y.Free;
       X.Free;
       R.Free;
       T.Free;
    end;
     
    procedure Matrix.Init( Size1, Size2 : LongWord );
    var
       i : LongWord;
    begin
       if Size1 = 0 then
          Error( 2018 );
     
       m := Size2;
       n := Size1;
     
       VAddr.Size := n * SizeOf( VectorPrim );
       GetMem( VAddr.Ptr, VAddr.Size );
       //   VAddr := GetVMem( n * SizeOf( VectorPrim ) );
     
          { Разпределить массив векторов-строк }
       for i := 1 to n do
          Addr^[ i ].Init( m );
     
       FInit := Indicator { Флаг инициализации }
    end;
     
    procedure Matrix.Init( A : Matrix );
    begin
       Init( A.n, A.m );
       Copy( A );
    end;
     
    procedure Matrix.InitTrans( A : Matrix );
    begin
       Init( A.m, A.n );
       Trans( A );
    end;
     
    procedure Matrix.Trans( A : Matrix );
    {
       Транспонирование матрицы A
    }
    var
       i : LongWord;
       x : Vector;
       B : Matrix;
    begin
       if ( n <> A.m ) or ( m <> A.n ) then
          Error( 116 );
     
       x.Init( A.n );
       B.Init( A.m, A.n );
     
       for i := 1 to A.m do
          begin
             x.Col( i, A );
             B.Row( i, x );
          end;
     
       Copy( B );
       B.Free;
       x.Free;
     
    end;
     
    procedure VectorPrim.Init( Size : LongWord );
    begin
       if Size = 0 then
          Error( 2017 );
     
       n := Size;
       { Распределить память для вектора }
       VAddr.Size := n * SizeOf( Real );
       GetMem( VAddr.Ptr, VAddr.Size );
       //   VAddr := GetVMem( n * SizeOf( Real ) );
       FInit := Indicator
    end;
     
    procedure Vector.InitRow( A : Matrix );
    begin
       Init( A.m );
    end;
     
    procedure Vector.InitCol( A : Matrix );
    begin
       Init( A.n );
    end;
     
    procedure Vector.InitRow( i : Integer; A : Matrix );
    begin
       InitRow( A );
       Row( i, A );
    end;
     
    procedure Vector.InitCol(  i : Integer; A : Matrix );
    begin
       InitCol( A );
       Col( i, A );
    end;
     
    procedure VectorPrim.Init( X : VectorPrim );
    begin
       n := X.n;
     
       { Распределить память для вектора }
       VAddr.Size := n * SizeOf( Real );
       GetMem( VAddr.Ptr, VAddr.Size );
       //   VAddr := GetVMem( n * SizeOf( Real ) );
       FInit := Indicator;
     
       Copy( X );
    end;
     
    procedure VectorPrim.SetAll( X : Real );
    var
       i : LongWord;
       t : ArrayPtr;
    begin
       t := Addr;
       for i := 1 to n do
          t^[ i ] := X;
    end;
     
    procedure Spline.Init( X, Y : Vector );
     
       procedure SplineXY;
          {
            Вычисление коэффициентов кубического сплайна функции
            заданной таблицей значений Y( x ).
          }
       var
          i, j : LongWord;
          f : Real;
       begin
          NumbSpline := 1;
          with Addr^ do
             begin
     
                for i := 1 to NPoint - 1 do
                   begin
                      h.E( i )^ := x.E( i + 1 )^ - x.E( i )^;
                      d.E( i )^ := ( y.E( i + 1 )^ - y.E( i )^ ) / h.E( i )^;
                   end;
     
                dg.E( 1 )^ := 2.;
                dg.E( NPoint )^ := 2.;
                d2.E( 1 )^ := 1.;
                d1.E( NPoint - 1 )^ := 1.;
                bb.E( 1 )^ := d.E( 1 )^ * 3.;
                bb.E( NPoint )^ := d.E( NPoint - 1 )^ * 3.;
     
                for i := 2 to NPoint - 1 do
                   begin
                      bb.E( i )^ := ( d.E( i )^ * h.E( i - 1 )^ + d.E( i - 1 )^ * h.E( i )^ ) * 3.;
                      d1.E( i - 1 )^ := h.E( i )^;
                      d2.E( i )^ := h.E( i - 1 )^;
                      dg.E( i )^ := 2. * ( h.E( i )^ + h.E( i - 1 )^ );
                   end;
                {
                    Решение системы линейных уравнений с 3-х диагональной
                    матрицей коэффициентов
                }
                for i := 1 to NPoint - 1 do
                   begin
                      f := d1.E( i )^ / dg.E( i )^;
                      dg.E( i + 1 )^ := dg.E( i + 1 )^ - d2.E( i )^ * f;
                      bb.E( i + 1 )^ := bb.E( i + 1 )^ - bb.E( i )^ * f;
                   end;
     
                bb.E( NPoint )^ := bb.E( NPoint )^ / dg.E( NPoint )^;
     
                for i := 1 to NPoint - 1 do
                   begin
                      j := NPoint - i;
                      bb.E( j )^ := ( bb.E( j )^ - d2.E( j )^ * bb.E( j + 1 )^ ) / dg.E( j )^;
                   end;
     
                for i := 1 to NPoint do
                   begin
                      d1.Copy( x ); { d1 - исходные значения X }
                      d2.Copy( y ); { d2 - ---:---- Y          }
                   end;
             end;
       end;
     
    begin
       VAddr.Size := SizeOf( SplineCoeffType );
       GetMem( VAddr.Ptr, SizeOf( SplineCoeffType ) );
       //   VAddr := GetVMem( SizeOf( SplineCoeffType ) );
     
       with Addr^ do
          begin
             NPoint := X.n;
             H.Init( X.n );
             D.Init( X.n );
             bb.Init( X.n );
             d1.Init( X.n );
             dg.Init( X.n );
             d2.Init( X.n );
          end;
     
       SplineXY;
     
    end;
     
    function Spline.F( X : Real ) : Real;
    {
       Вычисление значения сплайн-функции в точке X.
    }
     
       function SplineIndex : LongWord;
          {
             Вычисляет номер сплайна для точки 'X'.
          }
       var
          NS : LongWord;
     
          procedure IndRecurs( K, L : LongWord );
          var
             M : LongWord;
          begin
             with Addr^ do
                begin
                   NS := K;
     
                   if ( L - K ) <= 1 then
                      Exit;
     
                   M := ( ( K + L ) div 2 );
     
                   if ( ( X - D1.E( K )^ ) * ( X - D1.E( M )^ ) ) <= 0.0 then
                      IndRecurs( K, M )
                   else
                      IndRecurs( M, L );
                end;
          end;
     
       begin
          with Addr^ do
             begin
     
                SplineIndex := 1;
     
                if X <= d1.E( 1 )^ then
                   exit;
     
                SplineIndex := NPoint - 1;
     
                if X >= d1.E( NPoint )^ then
                   exit;
     
                IndRecurs( 1, NPoint );
                SplineIndex := NS;
     
             end;
       end;
     
    var
       j : LongWord;
       f1, t, s : Real;
    begin
       with Addr^ do
          begin
     
             j := SplineIndex;
     
             t := ( X - d1.E( j )^ ) / h.E( j )^;
             f1 := 1. - t;
             s := t * d2.E( j + 1 )^ + f1 * d2.E( j )^;
             s := s + h.E( j )^ * f1 * t * ( ( bb.E( j )^ - d.E( j )^ ) * f1
                - ( bb.E( j + 1 )^ - d.E( j )^ ) * t );
     
             F := s;
          end;
    end;
     
    function Spline.DF( X : real ) : real;
    {
       Вычисление первой производной от сплайн-функции в точке 'X'.
    }
    var
       Delta : real;
       Temp : Real;
       PA : PolyApprox;
       xS, yS : Vector;
     
       procedure PolyCalc( n : Integer );
       begin
          xS.Init( 5 );
          yS.Init( 5 );
          xS.SubVector( Addr^.D1, n, 5 );
          yS.SubVector( Addr^.D2, n, 5 );
          PA.Init( xS, yS, 5 );
          DF := PA.DPX( X );
          PA.Free;
          yS.Free;
          xS.Free;
       end;
     
    begin
       Delta := Abs( X ) * SqrtEps + SqrtEps;
     
       with Addr^ do
          begin
     
             if X - Delta <= D1.E( 1 )^ then
                Temp := -3 * F( X ) + 4 * F( X + Delta ) - F( X + 2 * Delta )
             else
                if X + Delta >= D1.E( Npoint )^ then
                   Temp := 3 * F( X ) - 4 * F( X - Delta ) + F( X - 2 * Delta )
                else
                   Temp := ( F( X + Delta ) - F( X - Delta ) );
     
             DF := Temp / Delta / 2;
          end;
    end;
     
    procedure VectorPrim.Free;
    begin
       FInit := 0;
       FreeMem( VAddr.Ptr, VAddr.Size );
       VAddr.Ptr := nil;
       //   FreeVMem( VAddr );
       //   VAddr := 0;
    end;
     
    procedure Matrix.Free;
    var
       i : LongWord;
    begin
       FInit := 0;
     
       for i := 1 to n do
          Addr^[ i ].Free;
     
       FreeMem( VAddr.Ptr, VAddr.Size );
       VAddr.Ptr := nil;
       //FreeVMem( VAddr );
       //   VAddr := 0;
    end;
     
    procedure Spline.Free;
    begin
       with Addr^ do
          begin
             H.Free;
             D.Free;
             bb.Free;
             d1.Free;
             dg.Free;
             d2.Free;
          end;
       FreeMem( VAddr.Ptr, VAddr.Size );
       VAddr.Ptr := nil;
       //FreeVMem( VAddr );
       //   VAddr := 0;
    end;
     
    function VectorPrim.Addr : ArrayPtr;
    begin
       Addr := VAddr.Ptr;
       //Addr := VirtualToPtr( VAddr );
    end;
     
    function Matrix.Addr : MatrixVPrimPtr;
    begin
       Addr := VAddr.Ptr;
       //Addr := VirtualToPtr( VAddr );
    end;
     
    function Matrix.E( I, J : LongWord ) : RealPtr;
    begin
       if ( i >= 1 ) and ( i <= n ) and ( j >= 1 ) and ( j <= m ) then
          E := System.Addr( Addr^[ i ].E( j )^ ) { Адрес элемента I,J }
       else
          Error( 4 );
    end;
     
    function VectorPrim.E( I : LongWord ) : RealPtr;
    begin
       if ( i >= 1 ) and ( i <= n ) then
          E := System.Addr( Addr^[ i ] ) { Адрес элемента I }
       else
          Error( 5 );
    end;
     
    procedure VectorPrim.Copy( X : VectorPrim );
    begin
       if FInit <> Indicator then
          Error( 100 );
       Move( X.Addr^, Addr^, X.n * SizeOf( Real ) ); { Быстрая пересылка }
    end;
     
    procedure Matrix.Copy( B : Matrix );
    var
       i : LongWord;
    begin
       if FInit <> Indicator then
          Error( 101 );
       for i := 1 to n do
          Addr^[ i ].Copy( B.Addr^[ i ] ); { Векторное копирование }
    end;
     
    procedure Matrix.Multiple( A, B : Matrix );
    {
       Вычисление произведения двух матриц
          = A * B
    }
    var
       i, j : LongWord;
       TX : Matrix;
       t1, t2 : Vector;
    begin
     
       if FInit <> Indicator then
          Error( 102 );
     
       TX.Init( A.n, B.m );
       t1.Init( A.m );
     
       t2.Init( B.n );
     
       for i := 1 to A.n do
          begin
             t1.Row( i, A );
             for j := 1 to B.m do
                begin
                   t2.Col( j, B );
                   t2.Multiple( t2, t1 );
                   TX.E( i, j )^ := t2.Summ;
                end;
          end;
     
       Copy( TX );
     
       TX.Free;
       t1.Free;
       t2.Free;
     
    end;
     
    procedure Matrix.Multiple( A, B : VectorPrim );
    {
                                                  T
       Вычисление произведения двух векторов A * B
    }
    var
       i, j : LongWord;
    begin
     
       if FInit <> Indicator then
          Error( 102 );
     
       if A.n <> B.n then
          Error( 4001 );
     
       if n <> m then
          Error( 4002 );
     
       if n <> A.n then
          Error( 4003 );
     
       for i := 1 to n do
          for j := 1 to n do
             E( i, j )^ := A.E( i )^ * B.E( j )^;
     
    end;
     
    procedure Vector.Multiple( A : Matrix; x : Vector );
    {
       Вычисление произведения матрицы на вектор
          = A * x
    }
    var
       i : LongWord;
       T1, T2 : Vector;
    begin
     
       if x.n <> A.m then
          Error( 6 );
     
       if FInit <> Indicator then
          Error( 103 );
     
       T1.Init( A.n );
       T2.Init( A.m );
     
       for i := 1 to A.n do
          begin
             T2.Row( i, A ); { Быстрая пересылка }
             T2.Multiple( T2, x ); { Умножение         }
             T1.Addr^[ i ] := T2.Summ; { Суммирование      }
          end;
     
       Copy( T1 );
     
       T1.Free;
       T2.Free;
     
    end;
     
    procedure VectorPrim.Multiple( x, y : VectorPrim );
    var
       i : LongWord;
       yp, xp, Sp : ArrayPtr;
    begin
       if x.n <> y.n then
          Error( 121 );
     
       Sp := Addr;
       xp := x.Addr;
       yp := y.Addr;
     
       for i := 1 to x.n do
          Sp^[ i ] := xp^[ i ] * yp^[ i ];
     
    end;
     
    procedure Vector.Divide( x : Vector; AB : Matrix );
    {
       Решение системы линейных алгебраических уравнений
       вида:
            A * y = b
       методом прямого деления.
    }
    var
       b : Matrix;
    begin
       if ( x.n <> AB.m ) or ( AB.m <> AB.n ) then
          Error( 7 );
     
       if FInit <> Indicator then { Новый вектор }
          Error( 104 );
     
       b.Init( AB.n, 1 );
       b.Col( 1, x );
     
       b.Divide( b, AB );
     
       Col( 1, b );
       b.Free;
     
    end;
     
    procedure Matrix.Divide( Bx, Ax : Matrix );
    {
       Решение матричной системы вида :
                    A * Y = B, где
          A[n,n], Y[n,m], B[n,m] m<=n
       может быть применена для обращения матрицы
       если В = Е.
    }
    var
       i, j, k : LongWord;
       d, t : real;
       a, b : Matrix;
       FBreak : Boolean;
    begin
     
       if FInit <> Indicator then { Новая матрица }
          Error( 105 );
     
       a.Init( Ax.n, Ax.m );
       b.Init( Bx.n, Bx.m );
     
       a.Copy( Ax );
       b.Copy( Bx );
     
       Condition := True;
       MinEps := 1.0;
     
       FBreak := false;
     
       for i := 1 to a.n do
          begin
             if System.Abs( a.E( i, i )^ ) = 0.0 then
                begin
                   Condition := Condition and ( i = 1 );
     
                   for j := 1 to a.n do
                      begin
                         if System.Abs( a.E( j, i )^ ) <> 0.0 then
                            begin
                               a.Addr^[ i ].Addition( a.Addr^[ i ], a.Addr^[ j ] );
                               b.Addr^[ i ].Addition( b.Addr^[ i ], b.Addr^[ j ] );
                               Break;
                            end;
                      end;
     
                   FBreak := True;
     
                end;
     
             if FBreak then
                Continue;
     
             for k := 1 to b.m do
                b.E( i, k )^ := b.E( i, k )^ / a.E( i, i )^;
     
             for k := a.n downto i do
                a.E( i, k )^ := a.E( i, k )^ / a.E( i, i )^;
     
             for j := 1 to a.n do
                begin
                   d := a.E( j, i )^;
     
                   if ( j <> i ) and ( System.Abs( d ) <> 0.0 ) then
                      begin
                         for k := i + 1 to a.n do
                            begin
                               t := a.E( j, k )^ / d - a.E( i, k )^;
     
                               a.E( j, k )^ := t;
                            end;
     
                         for k := 1 to b.m do
                            b.E( j, k )^ := b.E( j, k )^ / d - b.E( i, k )^;
     
                         if j < i then
                            a.E( j, j )^ := a.E( j, j )^ / d;
                      end;
                end;
          end;
     
       for i := 1 to a.n do
          for k := 1 to b.m do
             if a.E( i, i )^ <> 0 then
                E( i, k )^ := b.E( i, k )^ / a.E( i, i )^
             else
                E( i, k )^ := 0;
     
       a.Free;
       b.Free;
     
    end;
     
    procedure Vector.Diag( A : Matrix );
    {
       = Diag( A );
    }
    var
       i : LongWord;
       P : ArrayPtr;
    begin
       if FInit <> Indicator then { Новый вектор }
          Error( 106 );
     
       P := Addr;
     
       for i := 1 to n do
          P^[ i ] := A.E( i, i )^;
    end;
     
    procedure Vector.Col( i : LongWord; A : Matrix );
    {
       = A( *, i )
    }
    var
       j : LongWord;
       P : ArrayPtr;
    begin
       if FInit <> Indicator then { Проверк инициализации }
          Error( 107 );
     
       P := Addr;
     
       for j := 1 to A.n do
          P^[ j ] := A.E( j, i )^;
    end;
     
    procedure Vector.Row( i : LongWord; A : Matrix );
    {
       = A( i, * );
    }
    begin
       Copy( A.Addr^[ i ] );
    end;
     
    procedure VectorPrim.Addition( x, y : VectorPrim );
    {
       = x.e(*)^ + y.e(*)^;
    }
    var
       j : LongWord;
       xP, yP, sP : ArrayPtr;
    begin
     
       if ( x.n <> y.n ) then
          Error( 9 );
     
       if FInit <> Indicator then {  }
          Error( 108 );
     
       xP := x.Addr;
       yP := y.Addr;
       sP := Addr;
     
       for j := 1 to n do
          sP^[ j ] := xP^[ j ] + yP^[ j ];
    end;
     
    procedure VectorPrim.Substrac( x, y : VectorPrim );
    {
       = x.e(*)^ - y.e(*)^;
    }
    var
       j : LongWord;
       xP, yP, sP : ArrayPtr;
    begin
     
       if ( x.n <> y.n ) then
          Error( 10 );
     
       if FInit <> Indicator then
          Error( 109 );
     
       xP := x.Addr;
       yP := y.Addr;
       sP := Addr;
     
       for j := 1 to n do
          sP^[ j ] := xP^[ j ] - yP^[ j ];
    end;
     
    function VectorPrim.Summ : Real;
    {
       Сумма эл-тов вектора
    }
    var
       i : LongWord;
       S : Real;
       T : VectorPrim;
       AP : ArrayPtr;
    begin
       S := 0.0;
       T.Init( n );
     
       AP := T.Addr;
       Move( Addr^, AP^, n * SizeOf( Real ) );
     
       T.SortAbs( T ); { Сортировка по возрастанию }
     
       for i := 1 to n do { Суммируем начиная с меньших эл-тов }
          S := S + AP^[ i ];
     
       Summ := S;
     
       T.Free;
    end;
     
    function VectorPrim.SummSqr : Real;
    {
       Сумма квадратов эл-тов вектора
    }
    var
       i : LongWord;
       S : Real;
       T : VectorPrim;
       TP : ArrayPtr;
    begin
       S := 0.0;
     
       T.Init( n );
       TP := T.Addr;
     
       Move( Addr^, TP^, SizeOf( Real ) * n );
     
       T.SortAbs( T ); { сортировка по возрастанию }
     
       for i := 1 to n do
          S := S + Sqr( TP^[ i ] );
     
       SummSqr := S;
     
       T.Free;
    end;
     
    procedure Matrix.Addition( A, B : Matrix );
    {
       = A( *, * ) + B( *, * );
    }
    var
       i : LongWord;
    begin
       if ( A.n <> B.n ) or ( A.m <> B.m ) then
          Error( 11 );
     
       if FInit <> Indicator then
          Error( 110 );
     
       for i := 1 to n do
          Addr^[ i ].Addition( A.Addr^[ i ], B.Addr^[ i ] );
    end;
     
    procedure Matrix.Addition( A : Matrix; B : VectorPrim );
    {
       = A( *, * ) + B( *, * );
    }
    var
       i : LongWord;
    begin
     
       if ( A.n <> n ) or ( n <> m ) then
          Error( 11 );
     
       if FInit <> Indicator then
          Error( 110 );
     
       for i := 1 to n do
          E( i, i )^ := A.E( i, i )^ + B.E( i )^;
    end;
     
    procedure Matrix.Addition( A : Matrix; B : Real );
    {
       = A( *, * ) + B( *, * );
    }
    var
       i : LongWord;
    begin
     
       if ( A.n <> A.m ) then
          Error( 11 );
     
       if FInit <> Indicator then
          Error( 110 );
     
       Copy( A );
       for i := 1 to n do
          E( i, i )^ := A.E( i, i )^ + B;
    end;
     
    procedure Matrix.Substrac( A, B : Matrix );
    {
       = A( *, * ) - B( *, * );
    }
    var
       i : LongWord;
    begin
       if ( A.n <> B.n ) or ( A.m <> B.m ) then
          Error( 11 );
     
       if FInit <> Indicator then
          Error( 111 );
     
       for i := 1 to n do
          Addr^[ i ].Substrac( A.Addr^[ i ], B.Addr^[ i ] );
    end;
     
    procedure Matrix.Diag( b : VectorPrim );
    {
       Diag(*) = b(*);
    }
    var
       i : LongWord;
    begin
       if m <> b.n then
          Error( 12 );
       for i := 1 to n do
          E( i, i )^ := b.E( i )^;
    end;
     
    procedure Matrix.Diag( r : Real );
    {
       Diag(*) = r;
    }
    var
       i : LongWord;
    begin
       for i := 1 to n do
          E( i, i )^ := r;
    end;
     
    procedure Matrix.Col( i : LongWord; b : VectorPrim );
    {
       .e( *, i ) = b( * );
    }
    var
       j : LongWord;
    begin
       if n <> b.n then
          Error( 13 );
       for j := 1 to n do
          E( j, i )^ := b.E( j )^;
    end;
     
    procedure Matrix.Row( i : LongWord; b : VectorPrim );
    {
       .e( i, * ) = b( * );
    }
    begin
       if m <> b.n then
          Error( 13 );
       Addr^[ i ].Copy( b );
    end;
     
    procedure Matrix.Col( i : LongWord; r : Real );
    {
       .e( *, i ) = r;
    }
    var
       j : LongWord;
    begin
       for j := 1 to n do
          E( j, i )^ := r;
    end;
     
    procedure Matrix.Row( i : LongWord; r : Real );
    {
       .e( i, * ) = r;
    }
    var
       j : LongWord;
    begin
       for j := 1 to m do
          E( i, j )^ := r;
    end;
     
    function Spline.Addr : SplineCoeffPtr;
    begin
       Addr := VAddr.Ptr;
       //Addr := VirtualToPtr( VAddr );
    end;
     
    procedure VectorPrim.Sort( a1 : VectorPrim );
    {
       Quick-сортировка по возрастанию.
    }
    var
       a : ArrayPtr;
       t : Vector;
     
       procedure SortPrim( l, r : LongWord );
       var
          i, j : LongWord;
          x, y : Real;
       begin
          i := l;
          j := r;
          x := a^[ ( l + r ) div 2 ];
          repeat
     
             while a^[ i ] < x do
                i := i + 1;
     
             while x < a^[ j ] do
                j := j - 1;
     
             if i <= j then
                begin
                   y := a^[ i ];
                   a^[ i ] := a^[ j ];
                   a^[ j ] := y;
     
                   i := i + 1;
                   j := j - 1;
     
                end;
          until i > j;
     
          if l < j then
             SortPrim( l, j );
          if i < r then
             SortPrim( i, r );
     
       end;
     
    begin {quicksort}
       ;
     
       t.Init( a1.n );
       t.Copy( a1 );
       a := t.Addr;
     
       SortPrim( 1, N );
     
       Copy( t );
       t.Free;
    end;
     
    procedure VectorPrim.SortBy( a1 : VectorPrim );
    {
       Quick-сортировка по возрастанию.
    }
    var
       a, b : ArrayPtr;
       t : Vector;
     
       procedure SortPrim( l, r : LongWord );
       var
          i, j : LongWord;
          x, y : Real;
       begin
          i := l;
          j := r;
          x := a^[ ( l + r ) div 2 ];
          repeat
     
             while a^[ i ] < x do
                i := i + 1;
     
             while x < a^[ j ] do
                j := j - 1;
     
             if i <= j then
                begin
                   y := a^[ i ];
                   a^[ i ] := a^[ j ];
                   a^[ j ] := y;
     
                   y := b^[ i ];
                   b^[ i ] := b^[ j ];
                   b^[ j ] := y;
     
                   i := i + 1;
                   j := j - 1;
     
                end;
          until i > j;
     
          if l < j then
             SortPrim( l, j );
     
          if i < r then
             SortPrim( i, r );
     
       end;
     
    begin {quicksort}
       t.Init( a1.n );
       t.Copy( a1 );
       a := t.Addr;
       b := Addr;
     
       SortPrim( 1, N );
     
       {   Copy( t );}
       t.Free;
    end;
     
    procedure VectorPrim.SortAbs( a1 : VectorPrim );
    {
       Quick-сортировка по возрастанию ABS.
    }
    var
       a : ArrayPtr;
       t : Vector;
     
       procedure SortPrim( l, r : LongWord );
       var
          i, j : LongWord;
          x, y : Real;
       begin
          i := l;
          j := r;
          x := Abs( a^[ ( l + r ) div 2 ] );
          repeat
     
             while Abs( a^[ i ] ) < x do
                i := i + 1;
     
             while x < Abs( a^[ j ] ) do
                j := j - 1;
     
             if i <= j then
                begin
                   y := a^[ i ];
                   a^[ i ] := a^[ j ];
                   a^[ j ] := y;
     
                   i := i + 1;
                   j := j - 1;
     
                end;
          until i > j;
     
          if l < j then
             SortPrim( l, j );
          if i < r then
             SortPrim( i, r );
     
       end;
     
    begin {quicksort}
       t.Init( a1.n );
       t.Copy( a1 );
       a := t.Addr;
     
       SortPrim( 1, N );
     
       Copy( t );
       t.Free;
    end;
     
    procedure VectorPrim.Clear;
    begin
       SetAll( 0 );
    end;
     
    procedure Matrix.Clear;
    var
       i : LongWord;
    begin
       for i := 1 to n do
          Addr^[ i ].Clear;
    end;
     
    function Matrix.Alpha : Real;
    var
       QCond, xZ, HNorm : Real;
       Temp : Vector;
    begin
       Temp.Init( n );
       QCond := SELF.Cond;
       Temp.Diag( SELF );
       HNorm := Sqrt( Temp.SummSqr );
       xZ := Ln( MathEps ) * ( Ln( 1 / MathEps ) / ( Ln( QCond ) + Ln( 1 / MathEps ) ) );
       Alpha := Exp( xZ ) * HNorm;
       Temp.Free;
    end;
     
    procedure Matrix.Invert( A : Matrix );
    {
       Метод деления для вычисления обратной/псевдообратной матрицы 'A'.
    }
    var
       B : Matrix;
       Q : Matrix;
       R : Matrix;
       QCond, RCond : Real;
    begin
     
       Q.InitSqr( A );
       //
       //  Комбинированный метод корня и понижениея числа обусловленности
       //
       Q.Addition( Q, Q.Alpha );
     
       R.Init( Q );
     
       B.InitTrans( A );
     
       QCond := Q.Cond;
       //
       //   WriteLn('Cond(Q)=', QCond );
       //
       R.MSqrt( Q ); // квадратный корень Q
       RCond := R.Cond;
       //
       //   WriteLn('Cond(R)=', RCond );
       //
       //  Вычисление псевдообратной матрицы
       //
       B.Divide( B, R );
       R.Trans( R );
       Divide( B, R );
     
       Q.Free;
       R.Free;
       B.Free;
     
    end;
     
    procedure VectorPrim.Print;
    { (tail of DOS) }
    var
       i : LongWord;
       l : Integer;
    begin
       l := Trunc( ( 79 - n ) / n );
       if l < 9 then
          begin
             WriteLn( 'Warning, length of output digit < 9. ' );
             for i := 1 to n do
                WriteLn( i : 5, ' ', E( i )^ );
             exit;
          end;
     
       for i := 1 to n do
          Write( E( i )^ : l, ' ' );
     
       WriteLn;
     
    end;
     
    procedure VectorPrim.PrintF( M : Byte );
    {
      (tail of DOS)
    }
    var
       i : LongWord;
       l : Byte;
    begin
       l := Trunc( ( 79 - n ) / n );
     
       if l - M < 2 then
          begin
             WriteLn( 'Warning, invalid format' );
             exit;
          end;
     
       if l < 7 then
          begin
             WriteLn( 'Warning, length of fixed digit < 7. ' );
             exit;
          end;
     
       if l > 18 then
          l := 18;
     
       for i := 1 to n do
          Write( E( i )^ : l : M, ' ' );
       WriteLn;
     
    end;
     
    procedure Matrix.Print;
    {
       (tail of DOS)
    }
    var
       i : LongWord;
    begin
       for i := 1 to n do
          Addr^[ i ].Print;
       WriteLn;
    end;
     
    procedure Matrix.PrintF( M2 : Byte );
    {
       (tail of DOS)
    }
    var
       i : LongWord;
    begin
       for i := 1 to n do
          Addr^[ i ].PrintF( M2 );
       WriteLn;
    end;
     
    procedure VectorPrim.ScMultiple( X : Real; y : VectorPrim );
    var
       i : LongWord;
       t : ArrayPtr;
       yp : ArrayPtr;
    begin
       t := Addr;
       yp := y.Addr;
       for i := 1 to n do
          t^[ i ] := X * yp^[ i ]; { Быстрое умножение }
    end;
     
    procedure VectorPrim.ScDivide( X : Real; y : VectorPrim );
    var
       i : LongWord;
       t : ArrayPtr;
       yp : ArrayPtr;
    begin
       t := Addr;
       yp := y.Addr;
       for i := 1 to n do
          t^[ i ] := yp^[ i ] / X; { Быстрое умножение }
    end;
     
    procedure Matrix.ScMultiple( X : Real; Y : Matrix );
    var
       i : LongWord;
    begin
       for i := 1 to n do
          Addr^[ i ].ScMultiple( X, Y.Addr^[ i ] );
    end;
     
    begin
       {
          Вычисление точности:
              MathEps = относительная машинная точность.
                    ( -log( MathEps ) ~= к-во знаков в мантиссе. )
              SqrtEps = MathEps ^ 1/2;
                    ( - точность половина знаков мантиссы. )
              Eps = MathEps ^ 3/4;
                    ( --//-- 3/4 знаков мантиссы. )
       }
       MathEps := 1;
       repeat
          MathEps := MathEps / 2;
          Temp := 1 + MathEps;
       until Temp = 1;
     
       SqrtEps := Sqrt( MathEps );
     
       Eps := Sqrt( SqrtEps ) * SqrtEps;
     
       MinEps := 1;
     
       Randomize;
       Indicator := Random( $7FFF );
       //InitVHeap( '$$Matr.vhp', true );
    end.
     

Этот модуль используется почти во всех реализованных мной численных
алгоритмах и методах. Те части, которые писал не я, приводятся без
изменений (по возможности) стиля и комментариев.

    unit HNVString;
     
    interface
     
    {*********************************************************}
    {*                  OPSTRING.PAS 1.20                    *}
    {*     Copyright (c) TurboPower Software 1987, 1992.     *}
    {*                 All rights reserved.                  *}
    {*********************************************************}
     
    Type
       CharSet =
          Set of Char;
     
    function WordCount(S : string; WordDelims : CharSet) : Byte;
        {-Given a set of word delimiters, return number of words in S}
     
    function WordPosition(N : Byte; S : string; WordDelims : CharSet) : Byte;
        {-Given a set of word delimiters, return start position of N'th word in S}
     
    function ExtractWord(N : Byte; S : string; WordDelims : CharSet) : string;
        {-Given a set of word delimiters, return the N'th word in S}
     
    function RightJust( S : String; N : Word ) : String;
     
    Function HexB( B : Byte ):String;
     
    Function HexText( Var Buff; N : integer ) : String;
     
    implementation
     
    Const
       Dig : Array[0..$F]of Char = '0123456789ABCDEF';
     
    {
       Convert BYTE to Hex String
    }
    Function HexB( B : Byte ):String;
    Var
       T : String;
    begin
       T := '';
       T := T + Dig[ B shr 4 ];
       T := T + Dig[ B and $0F ];
       HexB := T;
    end;
    {
       Convert BUFFER to HEX String
    }
    Function HexText( Var Buff; N : integer ) : String;
    Type
       ByteArray =
          Array of Byte;
    Var
       i : integer;
       S : String;
       B : ByteArray Absolute Buff;
    begin
       S := '';
       for i:=1 to N do
          S := S + HexB( B[i] );
       HexText := S;
    end;
     
     
    function RightJust( S : String; N : Word ) : String;
    Var
       T : String;
       i : Integer;
       j : Integer;
    begin
       T := '';
       j := N;
       if Length( S ) > j then
          T := S
       else
          begin
             j := j - Length( S );
             for i:=1 to j do
                T := T + ' ';
             T := T + S;
          end;
       RightJust := T;
    end;
     
    function WordCount(S : string; WordDelims : CharSet) : Byte;
        {-Given a set of word delimiters, return number of words in S}
    var
       Count : Byte;         {!!.02}
       I : Word;                  {!!.02}
       SLen : Integer;
    begin
     
       SLen := Length( S );
       Count := 0;
       I := 1;
     
       while I <= SLen do
          begin
             {skip over delimiters}
             while (I <= SLen) and (S[I] in WordDelims) do
                Inc(I);
     
             {if we're not beyond end of S, we're at the start of a word}
             if I <= SLen then
                Inc(Count);
     
             {find the end of the current word}
             while (I <= SLen) and not(S[I] in WordDelims) do
                Inc(I);
          end;
     
       WordCount := Count;
    end;
     
    function WordPosition(N : Byte; S : string; WordDelims : CharSet) : Byte;
        {-Given a set of word delimiters, return start position of N'th word in S}
    var
       Count : Byte;         {!!.02}
       I : Word;                  {!!.02}
       SLen : Word;
    begin
       Count := 0;
       I := 1;
     
       SLen := Length( S );
     
       WordPosition := 0;
     
       while (I <= SLen) and (Count <> N) do
          begin
             {skip over delimiters}
             while (I <= SLen) and (S[I] in WordDelims) do
                Inc(I);
     
             {if we're not beyond end of S, we're at the start of a word}
             if I <= SLen then
                Inc(Count);
     
             {if not finished, find the end of the current word}
             if Count <> N then
                while (I <= SLen) and not(S[I] in WordDelims) do
                   Inc(I)
             else
                WordPosition := I;
          end;
    end;
     
    function ExtractWord(N : Byte; S : string; WordDelims : CharSet) : string;
        {-Given a set of word delimiters, return the N'th word in S}
    var
       I : Word; {!!.12}
       SLen : Integer;
       Temp : String;
    begin
     
       SLen := Length( S );
       Temp := '';
       I := WordPosition(N, S, WordDelims);
     
       if I <> 0 then
          {find the end of the current word}
          while (I <= SLen) and not(S[I] in WordDelims) do
             begin
                {add the I'th character to result}
                Temp := Temp + S[i];
                Inc(I);
             end;
     
        ExtractWord := Temp;
     
    end;
     
    end.


