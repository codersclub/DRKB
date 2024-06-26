---
Title: Математика, статистика и финансы
Date: 01.01.2007
---


Математика, статистика и финансы
================================

**Тригонометрические функции:**

function ArcCos(X: Extended): Extended;

function ArcSin(X: Extended): Extended;

function ArcTan2(Y, X: Extended): Extended; - Арктангенс X/Y возвращает угол в квадранте

procedure SinCos(Theta: Extended; var Sin, Cos: Extended) register; - возвращает сразу и синус и косинус, вычисления в 2 раза быстрее чем Sin, Cos по отдельности

function Tan(X: Extended): Extended;

function Cotan(X: Extended): Extended;

function Hypot(X, Y: Extended): Extended; - Возвращает значение гипотенузы по катетам

**Конвертация единиц измерения углов**

function DegToRad(Degrees: Extended): Extended;

function RadToDeg(Radians: Extended): Extended; 

function GradToRad(Grads: Extended): Extended; 

function RadToGrad(Radians: Extended): Extended;

function CycleToRad(Cycles: Extended): Extended;

function RadToCycle(Radians: Extended): Extended;

**Гиперболические функции**

function Cosh(X: Extended): Extended;

function Sinh(X: Extended): Extended;

function Tanh(X: Extended): Extended;

function ArcCosh(X: Extended): Extended;

function ArcSinh(X: Extended): Extended;

function ArcTanh(X: Extended): Extended;

**Логарифмы, экспоненты и возведение в степень**

function LnXP1(X: Extended): Extended; - натуральный логариф x+1 (для более высокой точности при x близких к нулю)

function Log10(X: Extended): Extended; - десятичный логарифм

function Log2(X: Extended): Extended;  - логарифм по основанию 2

function LogN(Base, X: Extended): Extended; - логарифм по произвольному основанию

function IntPower(Base: Extended; Exponent: Integer): Extended register;

function Power(Base, Exponent: Extended): Extended;

**Разные функции**

procedure Frexp(X: Extended; var Mantissa: Extended; var Exponent: Integer) register; - возвращает мантису и экспоненту

function Ldexp(X: Extended; P: Integer): Extended register; - возвращает X\*2\*\*P

function Ceil(X: Extended):Integer; - округляет до ближайшего большего целого

function Floor(X: Extended): Integer; - округляет до ближайшего меньшего целого

function Poly(X: Extended; const Coefficients: array of Double): Extended; - вычисление полинома

**Статистические функции**

function Mean(const Data: array of Double): Extended; среднее арифметическое

function Sum(const Data: array of Double): Extended register; сумма ряда

function SumInt(const Data: array of Integer): Integer register; сумма ряда целых чисел

function SumOfSquares(const Data: array of Double): Extended; сумма квадратов

procedure SumsAndSquares(const Data: array of Double; var Sum, SumOfSquares: Extended) register; сумма и сумма квадратов одной функцией

function MinValue(const Data: array of Double): Double; минимальное значение в ряду

function MinIntValue(const Data: array of Integer): Integer; минимальное значение в ряду целых

function Min(A,B) минимальное значение из 2х чисел (overload функции для Integer, Int64, Single, Double, Extended)

function MaxValue(const Data: array of Double): Double;

function MaxIntValue(const Data: array of Integer): Integer;

function Max(A,B);

function StdDev(const Data: array of Double): Extended; стандартное отклонение

procedure MeanAndStdDev(const Data: array of Double; var Mean, StdDev: Extended); - среднее арифметическое и стандартное отклонение

function PopnStdDev(const Data: array of Double): Extended; распределение стандартного отклонения (Population Standard Deviation)

function Variance(const Data: array of Double): Extended;

function PopnVariance(const Data: array of Double): Extended; (Population Variance)

function TotalVariance(const Data: array of Double): Extended;

function Norm(const Data: array of Double): Extended; среднее квадратичное (Sqrt(SumOfSquares))

procedure MomentSkewKurtosis(const Data: array of Double; var M1, M2, M3, M4, Skew, Kurtosis: Extended); основные статистические моменты

function RandG(Mean, StdDev: Extended): Extended; - случайные числа с Гауссовским распределением

**Финансовые функции**

function DoubleDecliningBalance(Cost, Salvage: Extended;  Life, Period: Integer): Extended;

function FutureValue(Rate: Extended; NPeriods: Integer; Payment, PresentValue:  Extended; PaymentTime: TPaymentTime): Extended;

function InterestPayment(Rate: Extended; Period, NPeriods: Integer; PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;

function InterestRate(NPeriods: Integer; Payment, PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;

function InternalRateOfReturn(Guess: Extended; const CashFlows: array of Double): Extended;

function NumberOfPeriods(Rate, Payment, PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;

function NetPresentValue(Rate: Extended; const CashFlows: array of Double; PaymentTime: TPaymentTime): Extended;

function Payment(Rate: Extended; NPeriods: Integer; PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;

function PeriodPayment(Rate: Extended; Period, NPeriods: Integer; PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;

function PresentValue(Rate: Extended; NPeriods: Integer; Payment, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;

function SLNDepreciation(Cost, Salvage: Extended; Life: Integer): Extended;

function SYDDepreciation(Cost, Salvage: Extended; Life, Period: Integer): Extended;
