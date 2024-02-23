using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SplashKitSDK;
using GeometryDraw.ObjectInterfaces;
using GeometryDraw.Extensions;
using GeometryDraw.Shapes;
using GeometryDraw.Creators;
using GeometryDraw.Executions;

/// <summary>
/// Object Interfaces (TypeObject,IDObject,...)
/// </summary>
namespace GeometryDraw.ObjectInterfaces
{
    /// <summary>
    /// Objects that can be identified with types
    /// </summary>
    /// <typeparam name="T"></typeparam>
    public class TypeObject<T>
    {
        private List<T> _types;
        public TypeObject(T[] types)
        {
            _types = new List<T>(types);
        }
        public TypeObject(T type) :
            this(new T[] { type })
        { }
        public bool IsType(T type)
        {
            return _types.Contains(type);
        }
        public void AddType(T type)
        {
            _types.Add(type);
        }
        public void AddType(T[] types)
        {
            foreach (T type in types)
            {
                _types.Add(type);
            }
        }
        public void AddType(List<T> types)
        {
            foreach (T type in types)
            {
                _types.Add(type);
            }
        }
        public void RemoveType(T type)
        {
            _types.Remove(type);
        }
        public void InitializeType(T[] types)
        {
            _types = new List<T>(types);
        }
        public void InitializeType(List<T> types)
        {
            _types = new List<T>(types);
        }
        public void InitializeType(T type)
        {
            _types = new List<T>(new T[] { type });
        }
        public List<T> TypeList
        {
            get
            {
                return _types;
            }
            set
            {
                _types = value;
            }
        }
    }
}

/// <summary>
/// Extensions for SplashKit structs
/// and List objects
/// </summary>
namespace GeometryDraw.Extensions
{
    /// <summary>
    /// Extensions for Vector2D
    /// </summary>
    public static partial class SplashKitExtended
    {
        /// <summary>
        /// Init are initializers
        /// </summary>
        /// <returns></returns>
        public static Vector2D Init(this Vector2D vector, double x, double y)
        {
            vector.X = x;
            vector.Y = y;
            return vector;
        }
        public static Vector2D Init(this Vector2D vector, double startx, double starty, double endx, double endy)
        {
            return vector.Init(endx - startx, endy - starty);
        }
        public static Vector2D Init(this Vector2D vector, Point2D startpoint, Point2D endpoint)
        {
            return vector.Init(startpoint.X, startpoint.Y, endpoint.X, endpoint.Y);
        }
        /// <summary>
        /// check if the vectors are parallel
        /// (vectors parallel, not equal)
        /// </summary>
        /// <param name="v1"></param>
        /// <param name="v2"></param>
        /// <returns></returns>
        public static bool ParallelTo(this Vector2D v1, Vector2D v2)
        {
            return (v1.X * v2.Y == v1.Y * v2.X);
        }
        /// <summary>
        /// reverse of the vector (0 - vector)
        /// </summary>
        /// <param name="vector"></param>
        /// <returns></returns>
        public static Vector2D Reverse(this Vector2D vector)
        {
            Vector2D v;
            v.X = -vector.X;
            v.Y = -vector.Y;
            return v;
        }
        /// <summary>
        /// return the vector perpendicular to the vector
        /// </summary>
        /// <param name="vector"></param>
        /// <returns></returns>
        public static Vector2D PerpendicularVector(this Vector2D vector)
        {
            Vector2D v;
            v.X = vector.Y;
            v.Y = vector.X;
            return v;
        }
        /// <summary>
        /// return length of vector
        /// the x and y of vector is determined
        /// </summary>
        /// <param name="vector"></param>
        /// <returns></returns>
        public static double Length(this Vector2D vector)
        {
            Point2D o, v;
            o.X = 0;
            o.Y = 0;
            v.X = vector.X;
            v.Y = vector.Y;
            return SplashKit.PointPointDistance(o, v);
        }
        /// <summary>
        /// return the length squared
        /// </summary>
        /// <param name="vector"></param>
        /// <returns></returns>
        public static double LengthSquared(this Vector2D vector)
        {
            return vector.X * vector.X + vector.Y * vector.Y;
        }
    }
    /// <summary>
    /// Extensions for Point2D
    /// </summary>
    public static partial class SplashKitExtended
    {
        /// <summary>
        /// Initializer
        /// </summary>
        /// <param name="point"></param>
        /// <param name="x"></param>
        /// <param name="y"></param>
        /// <returns></returns>
        public static Point2D Init(this Point2D point, double x, double y)
        {
            point = new Point2D();
            point.X = x;
            point.Y = y;
            return point;
        }
        /// <summary>
        /// check if two points are equal
        /// </summary>
        /// <param name="p1"></param>
        /// <param name="p2"></param>
        /// <returns></returns>
        public static bool EqualTo(this Point2D p1, Point2D p2)
        {
            return (p1.X == p2.X && p1.Y == p2.Y);
        }
        /// <summary>
        /// return the point from vector
        /// </summary>
        /// <param name="point"></param>
        /// <param name="vector"></param>
        /// <param name="distance"></param>
        /// <returns></returns>
        public static Point2D PointFromVector(this Point2D point, Vector2D vector, double distance)
        {
            Point2D p;
            Vector2D v = SplashKit.UnitVector(vector);
            // distance can be negative
            // it can depend on the direction
            p.X = point.X + distance * v.X;
            p.Y = point.Y + distance * v.Y;
            return p;
        }
        /// <summary>
        /// return point from vector
        /// just add the exact vector
        /// </summary>
        /// <param name="point"></param>
        /// <param name="vector"></param>
        /// <returns></returns>
        public static Point2D PointFromVector(this Point2D point, Vector2D vector)
        {
            Point2D p;
            p.X = point.X + vector.X;
            p.Y = point.Y + vector.Y;
            return p;
        }
        /// <summary>
        /// return the line from vector
        /// </summary>
        /// <param name="p1"></param>
        /// <param name="p2"></param>
        /// <returns></returns>
        public static Line LineFromVector(this Point2D point, Vector2D vector)
        {
            Line l = new Line();
            l.StartPoint = point;
            l.EndPoint = point.PointFromVector(vector);
            return l;
        }
        /// <summary>
        /// return the line perpendicular to a line
        /// from a point
        /// </summary>
        /// <param name="point"></param>
        /// <param name="line"></param>
        /// <returns></returns>
        public static Line LinePerpendicularTo(this Point2D point, Line line)
        {
            return point.LineFromVector(line.PerpendicularUnitVector());
        }
        /// <summary>
        /// return vector from point
        /// to point
        /// </summary>
        /// <param name="start"></param>
        /// <param name="end"></param>
        /// <returns></returns>
        public static Vector2D VectorToPoint(this Point2D start, Point2D end)
        {
            Vector2D v = new Vector2D();
            v.X = end.X - start.X;
            v.Y = end.Y - start.Y;
            return v;
        }
        /// <summary>
        /// return the projection point
        /// on the line
        /// this is different from the nearest point on line
        /// </summary>
        /// <param name="pt"></param>
        /// <param name="l"></param>
        /// <returns></returns>
        public static Point2D ProjectionOn(this Point2D pt, Line l)
        {
            Line line = pt.LinePerpendicularTo(l);
            Point2D x = SplashKitExtended.ExtendedIntersectionOf(line, l)[0];
            return x;
        }
    }
    /// <summary>
    /// Extensions for line
    /// </summary>
    public static partial class SplashKitExtended
    {
        /// <summary>
        /// exact vector of line
        /// </summary>
        /// <param name="line"></param>
        /// <returns></returns>
        public static Vector2D Vector(this Line line)
        {
            Vector2D v;
            v.X = line.EndPoint.X - line.StartPoint.X;
            v.Y = line.EndPoint.Y - line.StartPoint.Y;
            return v;
        }
        /// <summary>
        /// unit vector of line
        /// </summary>
        /// <param name="line"></param>
        /// <returns></returns>
        public static Vector2D UnitVector(this Line line)
        {
            return SplashKit.UnitVector(line.Vector());
        }
        /// <summary>
        /// perpendicular vector of line
        /// </summary>
        /// <param name="line"></param>
        /// <returns></returns>
        public static Vector2D PerpendicularVector(this Line line)
        {
            return line.Vector().PerpendicularVector();
        }
        /// <summary>
        /// perpendicular unit vector of line
        /// </summary>
        /// <param name="line"></param>
        /// <returns></returns>
        public static Vector2D PerpendicularUnitVector(this Line line)
        {
            return line.UnitVector().PerpendicularVector();
        }
    }
    /// <summary>
    /// Extensions for intersection points between lines and circles
    /// </summary>
    public static partial class SplashKitExtended
    {
        /// <summary>
        /// intersection of lines
        /// limited by their start and end points
        /// </summary>
        /// <param name="line1"></param>
        /// <param name="line2"></param>
        /// <returns></returns>
        public static List<Point2D> IntersectionOf(Line line1, Line line2)
        {
            if (SplashKit.LinesIntersect(line1, line2))
            {
                Point2D pt = new Point2D();
                SplashKit.LineIntersectionPoint(line1, line2, ref pt);
                List<Point2D> s = new List<Point2D>().Init(pt);
                return s;
            }
            else return null;
        }
        /// <summary>
        /// intersections of the extensions of lines
        /// not limited by start and end points
        /// if a line is not parallel to the line
        /// it intersects
        /// </summary>
        /// <param name="line1"></param>
        /// <param name="line2"></param>
        /// <returns></returns>
        public static List<Point2D> ExtendedIntersectionOf(Line line1, Line line2)
        {
            if (!line1.Vector().ParallelTo(line2.Vector()))
            {
                // use the coordinates to find the intersection point
                Point2D A1 = line1.StartPoint;
                Point2D A2 = line2.StartPoint;
                Vector2D v1 = line1.Vector();
                Vector2D v2 = line2.Vector();
                double u = (A2.X - A1.X) * v1.Y * v2.Y + A1.Y * v1.X * v2.Y - A2.Y * v2.X * v1.Y;
                double v = v1.X * v2.Y - v2.X * v1.Y;
                double y = u / v;
                double x = A1.X + (y - A1.Y) * v1.X / v1.Y;
                Point2D pt = new Point2D().Init(x, y);
                // put the point in a list to be able to return null
                List<Point2D> s = new List<Point2D>().Init(pt);
                return s;
            }
            else return null;
        }
        /// <summary>
        /// intersection of line and circle
        /// </summary>
        /// <param name="line"></param>
        /// <param name="circle"></param>
        /// <returns></returns>
        public static List<Point2D> IntersectionOf(Line line, Circle circle)
        {
            if (!SplashKit.LineIntersectsCircle(line, circle)) return null;
            Point2D H = circle.Center.ProjectionOn(line);
            double OP = circle.Radius;
            double OH = SplashKit.PointLineDistance(circle.Center, line);
            double x = OP * OP - OH * OH;
            if (x < 0) return null; // in case x is negative, which means line cannot intersect circle
            double HP = Math.Sqrt(OP * OP - OH * OH);
            Point2D P = H.PointFromVector(line.UnitVector(), HP);
            Point2D Q = H.PointFromVector(line.UnitVector().Reverse(), HP);
            // since operations on decimals may not correct in SplashKit
            // I need this to adjust the points so that the point can be 
            // exactly on the circle and line
            for(int i=0; i<1000; i++)
            {
                P = SplashKit.ClosestPointOnLine(P, line);
                P = SplashKit.ClosestPointOnCircle(P, circle);
                Q = SplashKit.ClosestPointOnLine(Q, line);
                Q = SplashKit.ClosestPointOnCircle(Q, circle);
            }
            // return the points list
            List<Point2D> s = new List<Point2D>();
            s.Add(P);
            // in case P = Q
            if (!P.EqualTo(Q))
            {
                s.Add(Q);
            }
            return s;
        }
        /// <summary>
        /// intersection between circles
        /// </summary>
        /// <param name="circle1"></param>
        /// <param name="circle2"></param>
        /// <returns></returns>
        public static List<Point2D> IntersectionOf(Circle circle1, Circle circle2)
        {
            if (SplashKit.CirclesIntersect(circle1, circle2))
            {
                Point2D A = circle1.Center;
                Point2D B = circle2.Center;
                Point2D P, Q, H;
                double AP = circle1.Radius;
                double BP = circle2.Radius;
                double AB = SplashKit.PointPointDistance(A, B);
                double AH = (AP * AP + AB * AB - BP * BP) / (2 * AB);
                double PH = Math.Sqrt(AP * AP - AH * AH);
                H.X = A.X + AH * (B.X - A.X) / AB;
                H.Y = A.Y + AH * (B.Y - A.Y) / AB;
                P.X = H.X + PH * (-B.Y + A.Y) / AB;
                P.Y = H.Y + PH * (B.X - A.X) / AB;
                Q.X = H.X - PH * (B.Y - A.Y) / AB;
                Q.Y = H.Y - PH * (-B.X + A.X) / AB;
                // since operations on decimals may not correct in SplashKit
                // I need this to adjust the points so that the point can be 
                // exactly on the circles
                for (int i = 0; i < 1000; i++)
                {
                    P = SplashKit.ClosestPointOnCircle(P, circle1);
                    P = SplashKit.ClosestPointOnCircle(P, circle2);
                    Q = SplashKit.ClosestPointOnCircle(Q, circle1);
                    Q = SplashKit.ClosestPointOnCircle(Q, circle2);
                }
                // return
                List<Point2D> s = new List<Point2D>();
                s.Add(P);
                if (!P.EqualTo(Q))
                {
                    s.Add(Q);
                }
                return s;
            }
            else return null;
        }
    }
    /// <summary>
    /// Extension for List
    /// </summary>
    public static class ListExtended
    {
        /// <summary>
        /// initialize
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="list"></param>
        /// <param name="item"></param>
        /// <returns></returns>
        public static List<T> Init<T>(this List<T> list, T item)
        {
            list = new List<T>(new T[] { item });
            return list;
        }
        /// <summary>
        /// Clear list
        /// </summary>
        /// <typeparam name="T"></typeparam>
        /// <param name="list"></param>
        public static void Clear<T>(this List<T> list)
        {
            foreach (T item in list)
            {
                list.Remove(item);
            }
        }
        /// <summary>
        /// return the list of item by type
        /// if an item type is an option type, 
        /// then it is added in the return list
        /// For example: sort the shape list:
        /// every point will be added first
        /// lines will be added later
        /// if we do not want circles in our list
        /// stop adding 
        /// and let the circles in the original list out
        /// </summary>
        /// <typeparam name="ItemType"></typeparam>
        /// <typeparam name="OptionType"></typeparam>
        /// <param name="list"></param>
        /// <param name="types"></param>
        /// <returns></returns>
        public static List<ItemType> ListOfItemsByTypeOrdered<ItemType, OptionType>
            (this List<ItemType> list, OptionType[] types)
            where ItemType : TypeObject<OptionType>
        {
            List<ItemType> newlist = new List<ItemType>();
            foreach (OptionType type in types)
            {
                foreach (ItemType item in list)
                {
                    if (item != null && item.IsType(type))
                    {
                        newlist.Add(item);
                    }
                }
            }
            return newlist;
        }
    }
}

/// <summary>
/// Shapes
/// The shape classes will be called GeoSomething
/// to distinguish with the SPlashKit shapes
/// </summary>
namespace GeometryDraw.Shapes
{
    /// <summary>
    /// Default values like color, size, ...
    /// </summary>
    public static class DefaultShapeValue
    {
        public static double Infinity = 10000;

        public static Color PointFreeDefaultColor = Color.Blue;
        public static double PointOnPlaneDefaultSize = 10;

        public static Color PointPathDefaultColor = Color.LightBlue;
        public static double PointOnPathDefaultSize = 6;

        public static Color PointStrictDefaultColor = Color.Black;
        public static double PointStrictDefaultSize = 4;

        public static Color PathDefaultColor = Color.Black;
        public static double PathDefaultClickRadius = 2;

        public static Color LineDefaultColor = Color.Black;
        public static double LineDefaultClickRadius = 2;

        public static Color CircleDefaultColor = Color.Black;
        public static double CircleDefaultClickRadius = 2;

        public static Color DefaultColorHovered = Color.Orange;
        public static Color DefaultColorSelected = Color.Red;
    }
    /// <summary>
    /// Types of shape
    /// Three general types of geometry shapes
    /// are: point, line, circle
    /// line and circle can be grouped as paths
    /// </summary>
    public enum GeoType
    {
        Shape,
        Movable,
        Path,
        Circle,
        Line,
        ExtendedLine,
        Segment,
        Ray,
        Point,
        PointFree,
        PointPath,
        PointStrict
    }
    /// <summary>
    /// The absolute abstract parent GeoShape class
    /// </summary>
    public abstract class GeoShape : TypeObject<GeoType>
    {
        private Color _color;
        private Color _colorSelected;
        private Color _colorHovered;
        private bool _selected;
        private bool _hovered;
        public GeoShape(GeoType[] types, Color color, Color colorHovered, Color colorSelected) :
            base(GeoType.Shape)
        {
            this.AddType(types);
            _selected = false;
            _hovered = false;
            _color = color;
            _colorHovered = colorHovered;
            _colorSelected = colorSelected;
        }
        public GeoShape(GeoType[] types, Color color) :
            this(types, color, DefaultShapeValue.DefaultColorHovered, DefaultShapeValue.DefaultColorSelected)
        { }
        public GeoShape(GeoType type, Color color) :
            this(new GeoType[] { type }, color)
        { }
        public Color Color
        {
            get
            {
                return _color;
            }
            set
            {
                _color = value;
            }
        }
        public Color ColorSelected
        {
            get
            {
                return _colorSelected;
            }
            set
            {
                _colorSelected = value;
            }
        }
        public Color ColorHovered
        {
            get
            {
                return _colorHovered;
            }
            set
            {
                _colorHovered = value;
            }
        }
        public bool Selected
        {
            get
            {
                return _selected;
            }
            set
            {
                _selected = value;
            }
        }
        public bool Hovered
        {
            get
            {
                return _hovered;
            }
            set
            {
                _hovered = value;
            }
        }
        public void Draw()
        {
            if (_selected) DrawSelected();
            else if (_hovered) DrawHovered();
            else DrawNormal();
        }
        public abstract void DrawNormal();
        public abstract void DrawSelected();
        public abstract void DrawHovered();
        public abstract bool IsAt(Point2D pt);
    }
    /// <summary>
    /// Interface declaring 
    /// what a movable shapes
    /// should have and do
    /// Movable shapes are shapes 
    /// that a user can click and drag
    /// </summary>
    public interface IShapeMovable
    {
        public bool Selected { get; }
        public void Move(double x, double y);
        /// <summary>
        /// Movable shapes must have an identifier
        /// (what type of data will determine the shape when it moves)
        /// This is used for the Creator tools 
        /// to identify and create the movable shape
        /// since every shape in the application 
        /// must be created with a creator
        /// to make a domino effect when an input shape is moved
        /// </summary>
        public abstract List<double> Identifier
        {
            get;
        }
    }
    /// <summary>
    /// general point
    /// </summary>
    public abstract class GeoPoint : GeoShape
    {
        private Point2D _point;
        private double _pointradius;
        public GeoPoint(double x, double y, double pointradius, Color color) :
            base(GeoType.Point, color)
        {
            _point.X = x;
            _point.Y = y;
            _pointradius = pointradius;
        }
        public GeoPoint(Point2D pt, double pointradius, Color color) :
            this(pt.X, pt.Y, pointradius, color)
        { }
        public override void DrawNormal()
        {
            SplashKit.FillCircle(Color, _point.X, _point.Y, _pointradius);
            SplashKit.DrawCircle(Color.Black, _point.X, _point.Y, _pointradius);
        }
        public override void DrawSelected()
        {
            SplashKit.FillCircle(ColorSelected, _point.X, _point.Y, _pointradius);
            SplashKit.DrawCircle(Color.Black, _point.X, _point.Y, _pointradius);
        }
        public override void DrawHovered()
        {
            SplashKit.FillCircle(ColorHovered, _point.X, _point.Y, _pointradius);
            SplashKit.DrawCircle(Color.Black, _point.X, _point.Y, _pointradius);
        }
        public override bool IsAt(Point2D pt)
        {
            if (SplashKit.PointPointDistance(pt, _point) <= _pointradius)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public Point2D Point
        {
            get
            {
                return _point;
            }
            set
            {
                _point = value;
            }
        }
        public double X
        {
            get
            {
                return _point.X;
            }
            set
            {
                _point.X = value;
            }
        }
        public double Y
        {
            get
            {
                return _point.Y;
            }
            set
            {
                _point.Y = value;
            }
        }
        public double PointRadius
        {
            get
            {
                return _pointradius;
            }
            set
            {
                _pointradius = value;
            }
        }
    }
    /// <summary>
    /// free point on plane
    /// </summary>
    public class GeoPointFree : GeoPoint, IShapeMovable
    {
        public GeoPointFree(double x, double y) :
            base(x, y, DefaultShapeValue.PointOnPathDefaultSize, DefaultShapeValue.PointFreeDefaultColor)
        {
            this.AddType(new GeoType[] { GeoType.Movable, GeoType.PointFree });
        }
        public GeoPointFree(Point2D pt) :
            this(pt.X, pt.Y)
        { }
        public void Move(double x, double y)
        {
            X = x;
            Y = y;
        }
        public List<double> Identifier
        {
            get
            {
                return new List<double>() { X, Y };
            }
        }
    }
    /// <summary>
    /// point on path
    /// free but is constricted by its path
    /// </summary>
    public class GeoPointPath : GeoPoint, IShapeMovable
    {
        private GeoPath _path;
        /// <summary>
        /// Point on path must be identified by a vector
        /// When the path is being moved
        /// the path remains the same shape, 
        /// just different scale
        /// therefore, point on path
        /// must be identified by a vector
        /// e.g. If a start point on a segment moves
        /// the ratio between 
        /// the distance from pointpath to start
        /// and the distance from pointpath to end
        /// stays the same
        /// </summary>
        /// <param name="identifierUnitVector"></param>
        /// <param name="path"></param>
        public GeoPointPath(Vector2D identifierUnitVector, GeoPath path) :
            base(0, 0, DefaultShapeValue.PointOnPathDefaultSize, DefaultShapeValue.PointPathDefaultColor)
        {
            _path = path;
            this.AddType(new GeoType[] { GeoType.Movable, GeoType.PointPath });
            this.Point = GetPositionOnPathFromIdentifier(identifierUnitVector, path);
        }
        /// <summary>
        /// get x y position from the identifier
        /// </summary>
        /// <param name="identifiervector"></param>
        /// <param name="path"></param>
        /// <returns></returns>
        public static Point2D GetPositionOnPathFromIdentifier(Vector2D identifiervector, GeoPath path)
        {
            Vector2D vt = new Vector2D();
            vt.X = identifiervector.X * path.PathVector.X - identifiervector.Y * path.PathVector.Y;
            vt.Y = identifiervector.X * path.PathVector.Y + identifiervector.Y * path.PathVector.X;
            Point2D pt = path.PathCenter.PointFromVector(vt);
            return pt; // just to be sure
        }
        /// <summary>
        /// with the x, y position
        /// set the identifier
        /// </summary>
        /// <param name="pointonpath"></param>
        /// <param name="path"></param>
        /// <returns></returns>
        public static Vector2D SetIdentifierFromPositionOnPath(Point2D pointonpath, GeoPath path)
        {
            Vector2D vt = path.PathCenter.VectorToPoint(pointonpath);
            Vector2D v;
            v.X = vt.X * path.PathVector.X + vt.Y * path.PathVector.Y;
            v.X = v.X / path.PathVector.LengthSquared();
            v.Y = -vt.X * path.PathVector.Y + vt.Y * path.PathVector.X;
            v.Y = v.Y / path.PathVector.LengthSquared();
            return v;
        }
        /// <summary>
        /// move: move point to the point on path 
        /// that is the nearest to the mouse cursor
        /// </summary>
        /// <param name="x"></param>
        /// <param name="y"></param>
        public void Move(double x, double y)
        {
            X = _path.NearestPointOf(x, y).X;
            Y = _path.NearestPointOf(x, y).Y;
        }
        public GeoPath Path
        {
            get
            {
                return _path;
            }
        }
        public List<double> Identifier
        {
            get
            {
                Vector2D v = SetIdentifierFromPositionOnPath(Point, Path);
                return new List<double>() { v.X, v.Y };
            }
        }
    }
    /// <summary>
    /// point strict
    /// e.g. middle point, intersection point,...
    /// cannot select and drag to move
    /// </summary>
    public class GeoPointStrict : GeoPoint
    {
        public GeoPointStrict(double x, double y) :
            base(x, y, DefaultShapeValue.PointStrictDefaultSize, DefaultShapeValue.PointStrictDefaultColor)
        {
            this.AddType(GeoType.PointStrict);
        }
        public GeoPointStrict(Point2D pt) :
            this(pt.X, pt.Y)
        { }
    }
    /// <summary>
    /// paths - abstract shapes
    /// </summary>
    public abstract class GeoPath : GeoShape
    {
        /// <summary>
        /// the distance of the border of the clickablearea 
        /// from the path itself
        /// when a user clicks on the clickable area
        /// it counts as the path is being clicked
        /// </summary>
        private double _clickarearadius;
        public GeoPath(Color color, double clickarearadius) :
            base(GeoType.Path, color)
        {
            _clickarearadius = clickarearadius;
        }
        public GeoPath(double clickarearadius) :
            this(DefaultShapeValue.PathDefaultColor, clickarearadius)
        { }
        public GeoPath() :
            this(DefaultShapeValue.PathDefaultClickRadius)
        { }
        /// <summary>
        /// path must have a center and a vector
        /// to determine the shape of the path
        /// if the path is moving,
        /// it may change its coordinates
        /// but the shape stays the same
        /// only the scale and angle of the path are altered
        /// </summary>
        public abstract Point2D PathCenter
        {
            get;
        }
        public abstract Vector2D PathVector
        {
            get;
        }
        public double ClickAreaRadius
        {
            get
            {
                return _clickarearadius;
            }
            set
            {
                _clickarearadius = value;
            }
        }
        /// <summary>
        /// nearest point of a mouseposition
        /// on path
        /// This is used when the point on path is being moved
        /// </summary>
        /// <param name="x"></param>
        /// <param name="y"></param>
        /// <returns></returns>
        public virtual Point2D NearestPointOf(double x, double y)
        {
            Point2D pt;
            pt.X = x;
            pt.Y = y;
            return this.NearestPointOf(pt);
        }
        public virtual Point2D NearestPointOf(Point2D pt)
        {
            return this.NearestPointOf(pt.X, pt.Y);
        }
        /// <summary>
        ///  check if a point is on path
        /// </summary>
        /// <param name="x"></param>
        /// <param name="y"></param>
        /// <returns></returns>
        public virtual bool IsOnPath(double x, double y)
        {
            Point2D pt;
            pt.X = x;
            pt.Y = y;
            return this.IsOnPath(pt);
        }
        public virtual bool IsOnPath(Point2D pt)
        {
            return this.IsOnPath(pt.X, pt.Y);
        }
    }
    /// <summary>
    /// circles
    /// </summary>
    public class GeoCircle : GeoPath
    {
        private Circle _circle;
        public GeoCircle(double x, double y, double radius, double clickarearadius) :
            base(clickarearadius)
        {
            this.AddType(GeoType.Circle);
            _circle.Center.X = x;
            _circle.Center.Y = y;
            _circle.Radius = radius;
        }
        public GeoCircle(double x, double y, double radius) :
            this(x, y, radius, DefaultShapeValue.CircleDefaultClickRadius)
        { }
        public GeoCircle(Circle c) :
            this(c.Center.X, c.Center.Y, c.Radius)
        { }
        public GeoCircle(Point2D center, double radius) :
            this(center.X, center.Y, radius)
        { }
        public override void DrawNormal()
        {
            SplashKit.DrawCircle(Color, _circle);
        }
        public override void DrawSelected()
        {
            SplashKit.DrawCircle(ColorSelected, _circle);
        }
        public override void DrawHovered()
        {
            SplashKit.DrawCircle(ColorHovered, _circle);
        }
        public override bool IsAt(Point2D pt)
        {
            if (SplashKit.PointPointDistance(pt, _circle.Center) <= (_circle.Radius + ClickAreaRadius)
                && SplashKit.PointPointDistance(pt, _circle.Center) >= (_circle.Radius - ClickAreaRadius))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public override bool IsOnPath(double x, double y)
        {
            double distanceToCenter = (_circle.Center.X - x) * (_circle.Center.X - x) + (_circle.Center.Y - y) * (_circle.Center.Y - y);
            if (distanceToCenter == _circle.Radius * _circle.Radius)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public override Point2D NearestPointOf(double x, double y)
        {
            Point2D pt;
            pt.X = x;
            pt.Y = y;
            Circle c = new Circle();
            c.Center.X = _circle.Center.X;
            c.Center.Y = _circle.Center.Y;
            c.Radius = _circle.Radius;
            return SplashKit.ClosestPointOnCircle(pt, _circle);
        }
        public override Point2D PathCenter
        {
            get
            {
                return Center;
            }
        }
        public override Vector2D PathVector
        {
            get
            {
                Vector2D v = new Vector2D();
                v.X = Radius;
                v.Y = 0;
                return v;
            }
        }
        public Circle Circle
        {
            get
            {
                return _circle;
            }
        }
        public Point2D Center
        {
            get
            {
                return _circle.Center;
            }
            set
            {
                _circle.Center = value;
            }
        }
        public double X
        {
            get
            {
                return _circle.Center.X;
            }
            set
            {
                _circle.Center.X = value;
            }
        }
        public double Y
        {
            get
            {
                return _circle.Center.Y;
            }
            set
            {
                _circle.Center.Y = value;
            }
        }
        public double Radius
        {
            get
            {
                return _circle.Radius;
            }
            set
            {
                _circle.Radius = value;
            }
        }
    }
    /// <summary>
    /// General line
    /// </summary>
    public abstract class GeoLine : GeoPath
    {
        private Line _line;
        private Vector2D _vector;
        private Point2D _pathcenter;
        private Vector2D _pathvector;
        public GeoLine(double startx, double starty, double endx, double endy, double clickarearadius) :
            base(clickarearadius)
        {
            this.AddType(GeoType.Line);

            _pathcenter.X = startx;
            _pathcenter.Y = starty;
            _pathvector.X = endx - startx;
            _pathvector.Y = endy - starty;

            _vector.X = endx - startx;
            _vector.Y = endy - starty;
            _vector = SplashKit.UnitVector(_vector);

            _line = new Line();
            _line.StartPoint.X = startx;
            _line.StartPoint.Y = starty;
            _line.EndPoint.X = endx;
            _line.EndPoint.Y = endy;
        }
        public GeoLine(double startx, double starty, double endx, double endy) :
            this(startx, starty, endx, endy, DefaultShapeValue.LineDefaultClickRadius)
        { }
        public GeoLine(Point2D start, Point2D end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoLine(Line line) :
            this(line.StartPoint.X, line.StartPoint.Y, line.EndPoint.X, line.EndPoint.Y)
        { }
        public override Point2D PathCenter
        {
            get
            {
                return _pathcenter;
            }
        }
        public override Vector2D PathVector
        {
            get
            {
                return _pathvector;
            }
        }
        public Line Line
        {
            get
            {
                return _line;
            }
        }
        public Vector2D UnitVector
        {
            get
            {
                return SplashKit.UnitVector(_vector);
            }
        }
        public Point2D StartPoint
        {
            get
            {
                return _line.StartPoint;
            }
            set
            {
                _line.StartPoint = value;
            }
        }
        public Point2D EndPoint
        {
            get
            {
                return _line.EndPoint;
            }
            set
            {
                _line.EndPoint = value;
            }
        }
        public double StartX
        {
            get
            {
                return _line.StartPoint.X;
            }
            set
            {
                _line.StartPoint.X = value;
            }
        }
        public double StartY
        {
            get
            {
                return _line.StartPoint.Y;
            }
            set
            {
                _line.StartPoint.Y = value;
            }
        }
        public double EndX
        {
            get
            {
                return _line.EndPoint.X;
            }
            set
            {
                _line.EndPoint.X = value;
            }
        }
        public double EndY
        {
            get
            {
                return _line.EndPoint.Y;
            }
            set
            {
                _line.EndPoint.Y = value;
            }
        }
        public override void DrawNormal()
        {
            SplashKit.DrawLine(Color, _line);
        }
        public override void DrawSelected()
        {
            SplashKit.DrawLine(ColorSelected, _line);
        }
        public override void DrawHovered()
        {
            SplashKit.DrawLine(ColorHovered, _line);
        }
        public override bool IsAt(Point2D pt)
        {
            return (SplashKit.PointLineDistance(pt, _line) <= ClickAreaRadius);
        }
        public override bool IsOnPath(Point2D pt)
        {
            return SplashKit.PointOnLine(pt, _line);
        }
        public override Point2D NearestPointOf(Point2D pt)
        {
            return SplashKit.ClosestPointOnLine(pt, _line);
        }
        public Point2D ProjectionOf(Point2D pt)
        {
            return pt.ProjectionOn(Line);
        }
    }
    /// <summary>
    /// Segment
    /// |----|
    /// </summary>
    public class GeoSegment : GeoLine
    {
        public GeoSegment(double startx, double starty, double endx, double endy) :
            base(startx, starty, endx, endy)
        {
            this.AddType(GeoType.Segment);
        }
        public GeoSegment(Point2D start, Point2D end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoSegment(GeoPoint start, GeoPoint end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoSegment(Line line) :
            this(line.StartPoint.X, line.StartPoint.Y, line.EndPoint.X, line.EndPoint.Y)
        { }
    }
    /// <summary>
    /// Ray
    /// |----|-----
    /// </summary>
    public class GeoRay : GeoLine
    {
        public GeoRay(double startx, double starty, double endx, double endy) :
            base(startx, starty, endx, endy)
        {
            this.AddType(GeoType.Ray);
            this.EndX = endx + DefaultShapeValue.Infinity * this.UnitVector.X;
            this.EndY = endy + DefaultShapeValue.Infinity * this.UnitVector.Y;
        }
        public GeoRay(Point2D start, Point2D end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoRay(GeoPoint start, GeoPoint end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoRay(Line line) :
            this(line.StartPoint.X, line.StartPoint.Y, line.EndPoint.X, line.EndPoint.Y)
        { }
    }
    /// <summary>
    /// Extended Line
    /// -----|----|-----
    /// </summary>
    public class GeoExtendedLine : GeoLine
    {
        public GeoExtendedLine(double startx, double starty, double endx, double endy) :
            base(startx, starty, endx, endy)
        {
            this.AddType(GeoType.ExtendedLine);
            this.StartX = startx - DefaultShapeValue.Infinity * this.UnitVector.X;
            this.StartY = starty - DefaultShapeValue.Infinity * this.UnitVector.Y;
            this.EndX = endx + DefaultShapeValue.Infinity * this.UnitVector.X;
            this.EndY = endy + DefaultShapeValue.Infinity * this.UnitVector.Y;
        }
        public GeoExtendedLine(Point2D start, Point2D end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoExtendedLine(GeoPoint start, GeoPoint end) :
            this(start.X, start.Y, end.X, end.Y)
        { }
        public GeoExtendedLine(Line line) :
            this(line.StartPoint.X, line.StartPoint.Y, line.EndPoint.X, line.EndPoint.Y)
        { }
    }
}

/// <summary>
/// Creator tools
/// These are the shape creators
/// Every shape must be created by a creator
/// so that the shape creating sequence is reserved
/// This is vital for anyone who wants to use this program
/// to create a geometry sketch
/// If not, when we move an input shape,
/// e.g. startpoint of a segment,
/// the segment will stay there and not move,
/// breaking the shape creation sequence
/// </summary>
namespace GeometryDraw.Creators
{
    /// <summary>
    /// A creator tool is basically a method
    /// that creates an output shape
    /// from an ordered list of input shapes
    /// and a list of data input
    /// data is a List of doubles
    /// </summary>
    public abstract class Creator
    {
        /// <summary>
        /// the type of the input shapes and output shapes
        /// ordered
        /// </summary>
        private GeoType[] _inputTypes;
        private GeoType[] _outputTypes;
        public Creator(GeoType[] inputTypes, GeoType[] outputTypes)
        {
            _inputTypes = inputTypes;
            _outputTypes = outputTypes;
        }
        public GeoType[] InputTypes
        {
            get
            {
                return _inputTypes;
            }
        }
        public GeoType[] OutputTypes
        {
            get
            {
                return _outputTypes;
            }
        }
        /// <summary>
        /// The main method that takes the inputs
        /// and output the shape
        /// This method will also be used later in the Execution objects
        /// </summary>
        /// <param name="shapeinput"></param>
        /// <param name="data"></param>
        /// <returns></returns>
        public virtual GeoShape OutputFrom(List<GeoShape> shapeinput, List<double> data)
        {
            return null;
        }
        /// <summary>
        /// Transform the input mouse positions 
        /// into meaningful input data 
        /// that will identify the shape throughout the application
        /// </summary>
        /// <param name="mousehistory"></param>
        /// <param name="inputshapes"></param>
        /// <returns></returns>
        public virtual List<double> MouseToData(List<double> mousehistory, List<GeoShape> inputshapes)
        {
            return null;
        }
    }
    /// <summary>
    /// Interface of all creator tools that uses data input
    /// </summary>
    public interface ICreateFromData
    {
        /// <summary>
        /// Each of these types of creators must have this method
        /// This method transforms the input mouse positions 
        /// into meaningful input data 
        /// that will strictly identify the shape throughout the application
        /// </summary>
        /// <param name="mousehistory"></param>
        /// <param name="inputs"></param>
        /// <returns></returns>
        public List<double> MouseToData(List<double> mousehistory, List<GeoShape> inputs);
    }
    /// <summary>
    /// Creator tool based on InputType and OutputType
    /// This makes creating a new creator easier
    /// since we will not have to 
    /// transfer the outputshape type into GeoShape type
    /// anymore
    /// </summary>
    /// <typeparam name="InputType"></typeparam>
    /// <typeparam name="OutputType"></typeparam>
    public abstract class Creator<InputType, OutputType> : Creator
        where InputType : GeoShape
        where OutputType : GeoShape
    {
        public Creator(GeoType[] inputTypes, GeoType[] outputTypes) :
            base(inputTypes, outputTypes)
        { }
        public bool InputTypeIsCorrect(List<InputType> input)
        {
            if (input.Count < InputTypes.Length) return false;
            for (int i = 0; i < InputTypes.Length; i++)
            {
                if (input[i] == null || !input[i].IsType(InputTypes[i]))
                {
                    return false;
                }
            }
            return true;
        }
        public override GeoShape OutputFrom(List<GeoShape> shapeinput, List<double> data)
        {
            List<InputType> input = new List<InputType>();
            foreach (GeoShape shape in shapeinput)
            {
                input.Add((InputType)shape);
            }
            if (!InputTypeIsCorrect(input)) return null;
            OutputType output = OutputFrom(input, data);
            return output;
        }
        public OutputType OutputFrom(List<InputType> input, List<double> data)
        {
            if (!InputTypeIsCorrect(input)) return null;
            else return Output(input, data);
        }
        protected virtual OutputType Output(List<InputType> input, List<double> data)
        {
            if (input == null && data == null) return Output();
            else if (data == null) return Output(input);
            else return Output(data);
        }
        protected virtual OutputType Output(List<InputType> input)
        {
            if (input == null) return Output();
            return Output(input, null);
        }
        protected virtual OutputType Output(List<double> data)
        {
            if (data == null) return Output();
            return Output(null, data);
        }
        protected virtual OutputType Output()
        {
            return null;
        }
    }
    
    /// The following classes are some of the major creators
    /// in a typical geometry drawing program
    /// Using the classes and interfaces above, 
    /// other programmers can create new creator tools 
    /// however they want 

    /// <summary>
    ///  create a free point on plane
    /// </summary>
    public class CreatePointFree : Creator<GeoPointFree, GeoPointFree>, ICreateFromData
    {
        public CreatePointFree() :
            base(new GeoType[] { },
                new GeoType[] { GeoType.PointFree })
        { }
        protected override GeoPointFree Output(List<double> data)
        {
            GeoPointFree p = new GeoPointFree(data[0], data[1]);
            return p;
        }
        /// <summary>
        /// transform the mouse position history into a constant identifier
        /// this identifier will not change until this point
        /// is being dragged on the screen
        /// </summary>
        /// <param name="mouse"></param>
        /// <param name="inputshapes"></param>
        /// <returns></returns>
        public override List<double> MouseToData(List<double> mouse, List<GeoShape> inputshapes)
        {
            return new List<double> { mouse[0], mouse[1] };
        }
    }

    /// <summary>
    /// create a point on path
    /// </summary>
    public class CreatePointPath : Creator<GeoPath, GeoPointPath>, ICreateFromData
    {
        public CreatePointPath() :
            base(new GeoType[] { GeoType.Path },
                new GeoType[] { GeoType.PointPath })
        { }
        protected override GeoPointPath Output(List<GeoPath> paths, List<double> identifier)
        {
            if (paths.Count == 1)
            {
                GeoPath path = paths[0];
                Vector2D v;
                v.X = identifier[0];
                v.Y = identifier[1];
                return new GeoPointPath(v, path);
            }
            return null;
        }
        /// <summary>
        /// transform mouse data history to the constant identifier
        /// </summary>
        /// <param name="mousehistory"></param>
        /// <param name="paths"></param>
        /// <returns></returns>
        public override List<double> MouseToData(List<double> mousehistory, List<GeoShape> paths)
        {
            Point2D mouse;
            mouse.X = mousehistory[0];
            mouse.Y = mousehistory[1];
            GeoPath path = paths[0] as GeoPath;
            Point2D pt = path.NearestPointOf(mouse);
            Vector2D v = GeoPointPath.SetIdentifierFromPositionOnPath(pt, path);
            return new List<double>() { v.X, v.Y };
        }
    }
    /// <summary>
    /// 
    /// Create point intersection
    /// This is an abstract class.
    /// There will be two createpointintersection class,
    /// since depending on the path
    /// there can be two intersection points
    /// 
    /// Initially, the Creator tool can output multiple shapes
    /// but I think it will be easier and more strict
    /// if each tool only outputs one shape
    /// 
    /// </summary>
    public abstract class CreatePointIntersection : Creator<GeoPath, GeoPointStrict>
    {
        public CreatePointIntersection() :
            base(new GeoType[] { GeoType.Path, GeoType.Path },
                new GeoType[] { GeoType.PointStrict })
        { }

        protected List<GeoPointStrict> IntersectionOf(GeoPath path1, GeoPath path2)
        {
            if (path1.IsType(GeoType.Line) && path2.IsType(GeoType.Circle))
            {
                return IntersectionLineCircle((GeoLine)path1, (GeoCircle)path2);
            }
            else if (path1.IsType(GeoType.Circle) && path2.IsType(GeoType.Line))
            {
                return IntersectionCircleLine((GeoCircle)path1, (GeoLine)path2);
            }
            else if (path1.IsType(GeoType.Line) && path2.IsType(GeoType.Line))
            {
                return IntersectionLineLine((GeoLine)path1, (GeoLine)path2);
            }
            else if (path1.IsType(GeoType.Circle) && path2.IsType(GeoType.Circle))
            {
                return IntersectionCircleCircle((GeoCircle)path1, (GeoCircle)path2);
            }
            else return null;
        }
        protected List<GeoPointStrict> IntersectionLineCircle(GeoLine line, GeoCircle circle)
        {
            if (SplashKit.LineIntersectsCircle(line.Line, circle.Circle))
            {
                List<Point2D> s = SplashKitExtended.IntersectionOf(line.Line, circle.Circle);
                List<GeoPointStrict> x = new List<GeoPointStrict>();
                foreach (Point2D pt in s)
                {
                    GeoPointStrict p = new GeoPointStrict(pt);
                    x.Add(p);
                }
                return x;
            }
            else
            {
                return null;
            }
        }
        protected List<GeoPointStrict> IntersectionCircleLine(GeoCircle circle, GeoLine line)
        {
            return IntersectionLineCircle(line, circle);
        }
        protected List<GeoPointStrict> IntersectionCircleCircle(GeoCircle circle1, GeoCircle circle2)
        {
            if (SplashKit.CirclesIntersect(circle1.Circle, circle2.Circle))
            {
                List<Point2D> s = SplashKitExtended.IntersectionOf(circle1.Circle, circle2.Circle);
                List<GeoPointStrict> x = new List<GeoPointStrict>();
                foreach (Point2D pt in s)
                {
                    GeoPointStrict p = new GeoPointStrict(pt);
                    x.Add(p);
                }
                return x;
            }
            else
            {
                return null;
            }
        }
        protected List<GeoPointStrict> IntersectionLineLine(GeoLine line1, GeoLine line2)
        {
            if (SplashKit.LinesIntersect(line1.Line, line2.Line))
            {
                List<Point2D> s = SplashKitExtended.IntersectionOf(line1.Line, line2.Line);
                List<GeoPointStrict> x = new List<GeoPointStrict>();
                foreach (Point2D pt in s)
                {
                    GeoPointStrict p = new GeoPointStrict(pt);
                    x.Add(p);
                }
                return x;
            }
            else return null;
        }
    }
    /// <summary>
    /// First CreatePointIntersection
    /// </summary>
    public class CreatePointIntersection1 : CreatePointIntersection
    {
        public CreatePointIntersection1() :
            base()
        { }
        protected override GeoPointStrict Output(List<GeoPath> input)
        {
            if (input.Count == 2 && input[0].IsType(GeoType.Path) && input[1].IsType(GeoType.Path))
            {
                List<GeoPointStrict> s = IntersectionOf(input[0], input[1]);
                if (s == null) return null;
                if (s.Count > 0) return s[0];
                else return null;
            }
            return null;
        }
    }
    /// <summary>
    /// Second CreatePointIntersection
    /// </summary>
    public class CreatePointIntersection2 : CreatePointIntersection
    {
        public CreatePointIntersection2() :
            base()
        { }
        protected override GeoPointStrict Output(List<GeoPath> input)
        {
            if (input.Count == 2 && input[0].IsType(GeoType.Path) && input[1].IsType(GeoType.Path))
            {
                List<GeoPointStrict> s = IntersectionOf(input[0], input[1]);
                if (s == null || s.Count <= 0) return null;
                if (s.Count > 1) return s[1];
                else return s[0];
            }
            return null;
        }
    }
    /// <summary>
    /// Create segment from two points
    /// (any point, not just free points)
    /// </summary>
    public class CreateSegment : Creator<GeoPoint, GeoSegment>
    {
        public CreateSegment() :
            base(new GeoType[] { GeoType.Point, GeoType.Point },
                new GeoType[] { GeoType.Line })
        { }
        protected override GeoSegment Output(List<GeoPoint> input)
        {
            return new GeoSegment(input[0], input[1]);
        }
    }
    /// <summary>
    /// Create ray
    /// </summary>
    public class CreateRay : Creator<GeoPoint, GeoRay>
    {
        public CreateRay() :
            base(new GeoType[] { GeoType.Point, GeoType.Point },
                new GeoType[] { GeoType.Ray })
        { }
        protected override GeoRay Output(List<GeoPoint> input)
        {
            return new GeoRay(input[0], input[1]);
        }
    }
    /// <summary>
    /// Create extended line
    /// </summary>
    public class CreateExtendedLine : Creator<GeoPoint, GeoExtendedLine>
    {
        public CreateExtendedLine() :
            base(new GeoType[] { GeoType.Point, GeoType.Point },
                new GeoType[] { GeoType.ExtendedLine })
        { }
        protected override GeoExtendedLine Output(List<GeoPoint> input)
        {
            return new GeoExtendedLine(input[0], input[1]);
        }
    }
    /// <summary>
    /// Create circle
    /// from a given center
    /// to another given point
    /// </summary>
    public class CreateCircleFromCenterToPoint : Creator<GeoPoint, GeoCircle>
    {
        public CreateCircleFromCenterToPoint() :
            base(new GeoType[] { GeoType.Point, GeoType.Point },
                new GeoType[] { GeoType.Circle })
        { }
        protected override GeoCircle Output(List<GeoPoint> input)
        {
            double radius = SplashKit.PointPointDistance(input[0].Point, input[1].Point);
            return new GeoCircle(input[0].Point, radius);
        }
    }
}

/// <summary>
/// Executions of the program
/// This includes all the things that helps run the application
/// </summary>
namespace GeometryDraw.Executions
{
    /// <summary>
    /// First is the Database.
    /// The database stores records of the shapes and how to create them
    /// </summary>
    /// 
    /// <summary>
    /// Each record will store both Hovered and Selected as Statuses
    /// since in the future, shape might also have other boolean statuses
    /// like Shown,...
    /// </summary>
    public struct StatusIndex
    {
        public const int Hovered = 0;
        public const int Selected = 1;
    }
    
    /// <summary>
    /// Record of the Database
    /// ID|Shape|Creator|ID of input shapes in the database|Data input|Status 
    /// There should be a status attribute to store the status of the shape
    /// cause when we regenerate the shape, the status of the shape 
    /// might be reverted back to false-false
    /// </summary>
    public class MyRecord
    {
        private MyDatabase _database;
        private string _id;
        private GeoShape _shape;
        private Creator _creator;
        private List<string> _inputIDs;
        private List<double> _data;
        private List<bool> _status;
        public MyRecord(MyDatabase database, string id, GeoShape shape, Creator creator, List<string> inputIDs, List<double> data, List<bool> status)
        {
            _database = database;
            _id = id;
            _shape = shape;
            _creator = creator;
            _inputIDs = inputIDs;
            _data = data;
            _status = status;
        }
        public string ID
        {
            get
            {
                return _id;
            }
        }
        public GeoShape Shape
        {
            get
            {
                return _shape;
            }
            set
            {
                _shape = value;
            }
        }
        public Creator Creator
        {
            get
            {
                return _creator;
            }
        }
        public List<string> InputIDs
        {
            get
            {
                return _inputIDs;
            }
        }
        public List<double> Data
        {
            get
            {
                return _data;
            }
            set
            {
                _data = value;
            }
        }
        public List<bool> Status
        {
            get
            {
                return _status;
            }
        }
        public bool Hovered
        {
            get
            {
                return _status[StatusIndex.Hovered];
            }
            set
            {
                _shape.Hovered = value;
                _status[StatusIndex.Hovered] = _shape.Hovered;
            }
        }
        public bool Selected
        {
            get
            {
                return _status[StatusIndex.Selected];
            }
            set
            {
                _shape.Selected = value;
                _status[StatusIndex.Selected] = _shape.Selected;
            }
        }
    }
    /// <summary>
    /// Database
    /// </summary>
    public partial class MyDatabase
    {
        private Dictionary<string, MyRecord> _database;
        public MyDatabase()
        {
            _database = new Dictionary<string, MyRecord>();
        }
        public Dictionary<string, MyRecord> Database
        {
            get
            {
                return _database;
            }
        }
        public List<GeoShape> ShapeList
        {
            get
            {
                List<GeoShape> shapelist = new List<GeoShape>();
                foreach (MyRecord record in RecordList)
                {
                    shapelist.Add(record.Shape);
                }
                return shapelist;
            }
        }
        public List<MyRecord> RecordList
        {
            get
            {
                return Database.Values.ToList();
            }
        }
        public List<string> IDList
        {
            get
            {
                return Database.Keys.ToList();
            }
        }
        public List<GeoShape> SelectedShapes
        {
            get
            {
                List<GeoShape> list = new List<GeoShape>();
                foreach (MyRecord record in RecordList)
                {
                    if (record.Selected)
                    {
                        list.Add(record.Shape);
                    }
                }
                return list;
            }
        }
        public GeoShape HoveredShape
        {
            get
            {
                foreach (MyRecord record in RecordList)
                {
                    if (record.Hovered) return record.Shape;
                }
                return null;
            }
        }
    }
    /// <summary>
    /// Database manager
    /// Basically only the database can retrieve, remove 
    /// and alter data of its own
    /// </summary>
    public partial class MyDatabase
    {
        /// <summary>
        /// Add records
        /// </summary>
        /// <param name="id"></param>
        /// <param name="shape"></param>
        /// <param name="creator"></param>
        /// <param name="inputIDlist"></param>
        /// <param name="data"></param>
        /// <param name="status"></param>
        public void AddRecord(
            string id,
            GeoShape shape,
            Creator creator,
            List<string> inputIDlist,
            List<double> data,
            List<bool> status)
        {
            MyRecord myRecord = new MyRecord(
                this,
                id,
                shape,
                creator,
                inputIDlist,
                data,
                status);
            Database.Add(id, myRecord);
        }
        /// <summary>
        /// Since every shape must constantly 
        /// be generated from the creator tool,
        /// every time the database alter the data
        /// it must regenerate the shape
        /// </summary>
        /// <param name="id"></param>
        /// <param name="creator"></param>
        /// <param name="inputIDlist"></param>
        /// <param name="data"></param>
        /// <param name="status"></param>
        public void AddRecord(
            string id,
            Creator creator,
            List<string> inputIDlist,
            List<double> data,
            List<bool> status)
        {
            GeoShape shape = GenerateShape(creator, inputIDlist, data, status);
            AddRecord(id, shape, creator, inputIDlist, data, status);
        }
        /// <summary>
        /// Generate all shapes
        /// </summary>
        public void GenerateAllShapes()
        {
            foreach (MyRecord record in RecordList)
            {
                record.Shape = GenerateShape(record.Creator, record.InputIDs, record.Data, record.Status);
            }
        }
        /// <summary>
        /// Generate one single shape
        /// using the creator tool and inputs 
        /// stored in the database 
        /// </summary>
        /// <param name="creator"></param>
        /// <param name="inputIDs"></param>
        /// <param name="data"></param>
        /// <param name="status"></param>
        /// <returns></returns>
        public GeoShape GenerateShape(Creator creator, List<string> inputIDs, List<double> data, List<bool> status)
        {
            List<GeoShape> inputshape = GetShapeListByIDs(inputIDs);
            GeoShape shape = creator.OutputFrom(inputshape, data);
            if (shape != null)
            {
                shape.Hovered = status[StatusIndex.Hovered];
                shape.Selected = status[StatusIndex.Selected];
            }
            return shape;
        }
        /// <summary>
        /// Changing the shape's data should be carefully done
        /// </summary>
        /// <param name="shape"></param>
        /// <param name="newdata"></param>
        public void ChangeShapeData(GeoShape shape, List<double> newdata)
        {
            Database[IDof(shape)].Data = new List<double>(newdata);
            GenerateAllShapes();
        }
        public string IDof(GeoShape shape)
        {
            foreach (string id in Database.Keys.ToList())
            {
                if (Database[id].Shape == shape)
                {
                    return id;
                }
            }
            return null;
        }
        public List<GeoShape> GetShapeListByIDs(List<string> inputIDs)
        {
            List<GeoShape> shapes = new List<GeoShape>();
            foreach (string id in inputIDs)
            {
                shapes.Add(Database[id].Shape);
            }
            return shapes;
        }
        public List<string> GetIDListByShapes(List<GeoShape> shapes)
        {
            List<string> inputIDs = new List<string>();
            foreach (GeoShape shape in shapes)
            {
                inputIDs.Add(IDof(shape));
            }
            return inputIDs;
        }
        /// <summary>
        /// Changing the status of a shape
        /// must be carefully done
        /// </summary>
        /// <param name="shape"></param>
        /// <param name="selected"></param>
        public void SetShapeSelected(GeoShape shape, bool selected)
        {
            if (shape != null)
            {
                Database[IDof(shape)].Selected = selected;
            }
        }
        public void SetShapeHovered(GeoShape shape, bool hovered)
        {
            if (shape != null)
            {
                Database[IDof(shape)].Hovered = hovered;
            }
        }
        public void RemoveShape(GeoShape shape)
        {
            string id = IDof(shape);
            Database.Remove(id);
            foreach (MyRecord record in RecordList)
            {
                if (record.InputIDs.Contains(id))
                {
                    Database.Remove(record.ID);
                }
            }
        }
    }

    /// <summary>
    /// Tools that the program/processor use
    /// Each tool should be able to access the database
    /// therefore each tool should have a Database property
    /// </summary>
    public abstract class MyProcessorTool
    {
        MyDatabase _database;
        public MyProcessorTool(MyDatabase database)
        {
            _database = database;
        }
        public MyDatabase Database
        {
            get
            {
                return _database;
            }
        }
    }
    /// <summary>
    /// Cursor do what a cursor do
    /// Move shape, select shape, hover shape...
    /// </summary>
    public class MyCursor : MyProcessorTool
    {
        public MyCursor(MyDatabase database) :
            base(database)
        { }

        public List<GeoShape> ListOfShapesByTypeOrdered(GeoType[] types)
        {
            List<GeoShape> shapes =
                Database.ShapeList.ListOfItemsByTypeOrdered(types);
            return shapes;
        }
        public void UnHoverAllShapes()
        {
            foreach (GeoShape s in Database.ShapeList)
            {
                if (s == null) continue;
                Database.SetShapeHovered(s, false);
            }
        }
        public void HoverShapesAt(Point2D pt)
        {
            HoverShapesByType(
                pt,
                new GeoType[]
                {
                    GeoType.PointFree,
                    GeoType.PointPath,
                    GeoType.Point,
                    GeoType.Shape
                }
            );
        }
        public void HoverShapesByType(Point2D pt, GeoType type)
        {
            HoverShapesByType(pt, new GeoType[] { type });
        }
        public void HoverShapesByType(Point2D pt, GeoType[] types)
        {
            UnHoverAllShapes();
            List<GeoShape> shapes = ListOfShapesByTypeOrdered(types);
            foreach (GeoShape s in shapes)
            {
                if (s == null) continue;
                if (s.IsAt(pt) && !s.Selected)
                {
                    Database.SetShapeHovered(s, true);
                    break;
                }
                else
                {
                    Database.SetShapeHovered(s, false);
                }
            }
        }
        public void UnselectAllShapes()
        {
            foreach (GeoShape shape in Database.ShapeList)
            {
                if (shape == null) continue;
                Database.SetShapeSelected(shape, false);
            }
        }
        public GeoShape SelectShapesByType(Point2D pt, GeoType type)
        {
            return SelectShapesByType(pt, new GeoType[] { type });
        }
        public GeoShape SelectShapesByType(Point2D pt, GeoType[] types)
        {
            List<GeoShape> shapes = ListOfShapesByTypeOrdered(types);
            foreach (GeoShape s in Database.ShapeList)
            {
                if (s == null) continue;
                if (!shapes.Contains(s))
                {
                    Database.SetShapeSelected(s, false);
                }
            }
            foreach (GeoShape s in shapes)
            {
                if (s == null) continue;
                if (s.IsAt(pt) && !s.Selected)
                {
                    Database.SetShapeSelected(s, true);
                    return s;
                }
            }
            return null;
        }
        public void SelectOneShapeAt(Point2D pt)
        {
            UnselectAllShapes();
            if (Database.HoveredShape != null)
            {
                Database.SetShapeSelected(Database.HoveredShape, true);
            }
        }
        public void SelectMultipleShapeAt(Point2D pt)
        {
            if (Database.HoveredShape != null)
            {
                Database.SetShapeSelected(Database.HoveredShape, true);
            }
        }
        public void MoveShapesAt(Point2D pt)
        {
            List<GeoShape> shapes = Database.ShapeList.ListOfItemsByTypeOrdered(
                new GeoType[]
                {
                    GeoType.Movable
                }
            );
            foreach (GeoShape s in shapes)
            {
                if (s == null) continue;
                IShapeMovable shape = s as IShapeMovable;
                if (shape.Selected)
                {
                    shape.Move(pt.X, pt.Y);
                    Database.ChangeShapeData(s, shape.Identifier);
                }
            }
        }
    }
    /// <summary>
    /// Drawer draw the shape
    /// </summary>
    public class MyDrawer : MyProcessorTool
    {
        public MyDrawer(MyDatabase database) :
            base(database)
        { }

        public void Draw()
        {
            SplashKit.ProcessEvents();
            foreach (GeoShape shape in Database.ShapeList)
            {
                if (shape != null) shape.Draw();
            }
        }
    }
    
    /// <summary>
    /// Main processor of the application
    /// This is the most important part of the program
    /// It is basically the program itself
    /// The processor control what the application should do,
    /// but it does not know what mode the application is on
    /// </summary>
    public class MyProcessor
    {
        private List<double> _tempMouse;
        private List<GeoShape> _tempShape;
        private MyDatabase _database;
        private long _ide;
        public MyProcessor(MyDatabase database)
        {
            _database = database;
            _tempMouse = new List<double>();
            _tempShape = new List<GeoShape>();
            _ide = 0;
        }
        public MyProcessor() : this(new MyDatabase()) { }
        public MyDatabase Database
        {
            get
            {
                return _database;
            }
        }
        public MyCursor Cursor
        {
            get
            {
                return new MyCursor(Database);
            }
        }
        public MyDrawer Drawer
        {
            get
            {
                return new MyDrawer(Database);
            }
        }
        /// <summary>
        /// basically this execute what the processor should do
        /// during a mode
        /// </summary>
        /// <param name="mode"></param>
        public void ActionFromMode(Mode mode)
        {
            ModeValues.ModeAction[mode](this);
        }
        public void Draw()
        {
            Drawer.Draw();
        }
        public void SelectMoveRemoveShape()
        {
            /// keep hovering the shapes
            Cursor.HoverShapesAt(SplashKit.MousePosition());
            /// checks if mouse clicked
            if (SplashKit.MouseClicked(MouseButton.LeftButton))
            {
                if (SplashKit.KeyDown(KeyCode.LeftCtrlKey)
                    || SplashKit.KeyDown(KeyCode.RightCtrlKey))
                {
                    Cursor.SelectMultipleShapeAt(SplashKit.MousePosition());
                }
                else Cursor.SelectOneShapeAt(SplashKit.MousePosition());
            }
            /// we can also delete shape
            if (SplashKit.KeyTyped(KeyCode.BackspaceKey) ||
                SplashKit.KeyTyped(KeyCode.DeleteKey))
            {
                foreach (GeoShape shape in Database.SelectedShapes)
                {
                    Database.RemoveShape(shape);
                }
            }
            /// move shape
            if (SplashKit.MouseDown(MouseButton.LeftButton))
            {
                Cursor.UnHoverAllShapes();
                Cursor.MoveShapesAt(SplashKit.MousePosition());
            }
        }
        public void MoveShapes()
        {
            if (SplashKit.MouseDown(MouseButton.LeftButton))
            {
                Cursor.MoveShapesAt(SplashKit.MousePosition());
            }
            else
            {
                SelectMoveRemoveShape();
            }
        }
        public void ClearCache()
        {
            _tempMouse.Clear();
            _tempShape.Clear();
            Cursor.UnselectAllShapes();
        }
        /// <summary>
        /// Creating a shape with a creator tool
        /// First it uses the cursor to select the 
        /// necessary input for the creator
        /// while also recording the mouse position history
        /// then it uses the inputs to create the shape with the creator tool
        /// and stores the collected data into the database
        /// </summary>
        /// <param name="creator"></param>
        public void CreateShapeWith(Creator creator)
        {
            // keep hovering shape until mouse click
            KeepHoveringShape();
            // when mouse click
            if (SplashKit.MouseClicked(MouseButton.LeftButton))
            {
                // in case no input shapes are required
                if (creator.InputTypes.Length == 0)
                {
                    // just add mouse history only
                    AddMouseHistory();
                }
                else if (Database.SelectedShapes.Count < creator.InputTypes.Length)
                {
                    // set the selected shape selected to be an input shape
                    SelectNewShape();
                }
                // add new shape
                if (Database.SelectedShapes.Count == creator.InputTypes.Length)
                {
                    AddNewRecordFromSelectedInputShapes();
                    ClearCache();
                }
            }
            // encapsulating procedures in this method
            void KeepHoveringShape()
            {
                // only hover shapes that is part of the input
                if (creator.InputTypes.Length > 0
                && _tempShape.Count < creator.InputTypes.Length)
                {
                    GeoType type = creator.InputTypes[_tempShape.Count];
                    Cursor.HoverShapesByType(SplashKit.MousePosition(), type);
                }
            }
            void SelectNewShape()
            {
                GeoType type = creator.InputTypes[_tempShape.Count];
                GeoShape shape = Cursor.SelectShapesByType(SplashKit.MousePosition(), type);
                if (shape != null)
                {
                    Database.SetShapeSelected(shape, true);
                    AddShapeHistory(shape);
                    AddMouseHistory();
                }
            }
            void AddShapeHistory(GeoShape shape)
            {
                _tempShape.Add(shape);
            }
            void AddMouseHistory()
            {
                _tempMouse.Add(SplashKit.MouseX());
                _tempMouse.Add(SplashKit.MouseY());
            }
            void AddNewRecordFromSelectedInputShapes()
            {
                List<GeoShape> inputshapes = _tempShape;
                List<string> inputIDlist = Database.GetIDListByShapes(inputshapes);
                List<double> data = creator.MouseToData(_tempMouse, inputshapes);
                _ide++;
                Database.AddRecord($"{_ide}", creator, inputIDlist, data, new List<bool> { false, false });
                ClearCache();
            }
        }
    }
    /// <summary>
    /// Mode
    /// </summary>
    public enum Mode
    {
        PointFree,
        Select,
        Move,
        Segment,
        Ray,
        ExtendedLine,
        PointPath,
        PointIntersection1,
        PointIntersection2,
        CircleCenterToPoint,
    }
    /// <summary>
    /// The values associating with the mode
    /// </summary>
    public static class ModeValues
    {
        public static Dictionary<Mode, Action<MyProcessor>> ModeAction = new Dictionary<Mode, Action<MyProcessor>>()
        {
            { Mode.Select, (a) => a.SelectMoveRemoveShape()},
            { Mode.Move, (a) => a.MoveShapes()},
            { Mode.PointFree, (a) => a.CreateShapeWith(new CreatePointFree())},
            { Mode.Segment, (a) => a.CreateShapeWith(new CreateSegment()) },
            { Mode.Ray, (a) => a.CreateShapeWith(new CreateRay()) },
            { Mode.ExtendedLine, (a) => a.CreateShapeWith(new CreateExtendedLine()) },
            { Mode.PointPath, (a) => a.CreateShapeWith(new CreatePointPath()) },
            { Mode.PointIntersection1, (a) => a.CreateShapeWith(new CreatePointIntersection1()) },
            { Mode.PointIntersection2, (a) => a.CreateShapeWith(new CreatePointIntersection2()) },
            { Mode.CircleCenterToPoint, (a) => a.CreateShapeWith(new CreateCircleFromCenterToPoint()) },
        };
        public static Dictionary<KeyCode, Mode> ModeFromKey = new Dictionary<KeyCode, Mode>()
        {
            { KeyCode.PKey, Mode.PointFree },
            { KeyCode.SKey, Mode.Select },
            { KeyCode.MKey, Mode.Move },
            { KeyCode.GKey, Mode.Segment },
            { KeyCode.RKey, Mode.Ray },
            { KeyCode.EKey, Mode.ExtendedLine },
            { KeyCode.HKey, Mode.PointPath },
            { KeyCode.Num1Key, Mode.PointIntersection1 },
            { KeyCode.Num2Key, Mode.PointIntersection2 },
            { KeyCode.CKey, Mode.CircleCenterToPoint },
        };
        public static Dictionary<string, Mode> ModeFromID = new Dictionary<string, Mode>()
        {
            { "Create point on plane", Mode.PointFree },
            { "Select a shape", Mode.Select },
            { "Move a shape", Mode.Move },
            { "Create segment from two points", Mode.Segment },
            { "Create ray from two points", Mode.Ray },
            { "Create extended line from two points", Mode.ExtendedLine },
            { "Create a point on a path", Mode.PointPath },
            { "Create an intersection point 1", Mode.PointIntersection1 },
            { "Create an intersection point 2", Mode.PointIntersection2 },
            { "Create a circle from a center and a point", Mode.CircleCenterToPoint },
        };
    }
    /// <summary>
    /// The general main application of the program
    /// This is the one that knows the mode of the application
    /// </summary>
    public class MyApplication
    {
        private MyProcessor _myProcessor;
        private Mode _myMode;
        public MyApplication()
        {
            _myProcessor = new MyProcessor();
            _myMode = Mode.PointFree;
        }
        public void ExecuteInTheLoop()
        {
            SetModeFromKeyTyped();
            _myProcessor.ActionFromMode(_myMode);
            _myProcessor.Draw();
        }
        /// <summary>
        /// Unfortunately, splashkit is different from windows
        /// so it is quite hard to run a splashkit window in wpf
        /// For now, this program only sets the mode with the key typed
        /// </summary>
        public void SetModeFromKeyTyped()
        {
            foreach (KeyCode key in ModeValues.ModeFromKey.Keys.ToList())
            {
                if (SplashKit.KeyTyped(key))
                {
                    _myMode = ModeValues.ModeFromKey[key];
                    _myProcessor.ClearCache();
                }
            }
        }
    }
}

/// <summary>
/// Final main program
/// </summary>
namespace GeometryDraw.Program
{
    public class Program
    {
        public static void Main(string[] args)
        {
            new Window("Geometry Draw", 800, 600);
            MyApplication program = new MyApplication();
            do
            {
                SplashKit.ProcessEvents();
                SplashKit.ClearScreen();
                program.ExecuteInTheLoop();
                SplashKit.RefreshScreen();
            } while (!SplashKit.WindowCloseRequested("Geometry Draw"));
        }
    }
}