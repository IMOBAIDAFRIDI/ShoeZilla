const express = require('express');
const path = require('path');
const session = require('express-session');
const sequelize = require('./models/database');

// Import Models
const User = require('./models/User');
const Product = require('./models/Product');
const { Order, OrderItem } = require('./models/Order');
const ContactMessage = require('./models/ContactMessage');

// Associations
User.hasMany(Order);
Order.belongsTo(User);

Order.hasMany(OrderItem);
OrderItem.belongsTo(Order);

Product.hasMany(OrderItem);
OrderItem.belongsTo(Product);


const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'wwwroot')));

// Session Setup
app.use(session({
    secret: 'shoezilla-secret-key',
    resave: false,
    saveUninitialized: false,
    cookie: { maxAge: 1000 * 60 * 60 * 24 } // 24 hours
}));

// View Engine Setup
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Pass user to all views
app.use((req, res, next) => {
    res.locals.user = req.session.user || null;
    res.locals.cartCount = req.session.cart ? req.session.cart.reduce((sum, item) => sum + item.quantity, 0) : 0;
    next();
});

// Import Routes
const indexRoutes = require('./routes/index');
const adminRoutes = require('./routes/admin');
const authRoutes = require('./routes/auth');
const cartRoutes = require('./routes/cart');

// Use Routes
app.use('/', indexRoutes);
app.use('/admin', adminRoutes);
app.use('/auth', authRoutes);
app.use('/cart', cartRoutes);



// Sync Database and Start Server
sequelize.sync().then(() => {
    app.listen(PORT, () => {
        console.log(`Server is running on http://localhost:${PORT}`);
    });
}).catch(err => {
    console.error('Database sync failed:', err);
});
