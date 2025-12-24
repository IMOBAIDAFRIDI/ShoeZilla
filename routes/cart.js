const express = require('express');
const router = express.Router();
const Product = require('../models/Product');
const { Order, OrderItem } = require('../models/Order');

// Middleware to ensure cart exists in session
router.use((req, res, next) => {
    if (!req.session.cart) {
        req.session.cart = [];
    }
    next();
});

// View Cart
router.get('/', (req, res) => {
    const cart = req.session.cart;
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    res.render('cart/index', { title: 'Shopping Cart', cart, total });
});

// Add to Cart
router.post('/add', async (req, res) => {
    const { productId } = req.body;
    try {
        const product = await Product.findByPk(productId);
        if (product) {
            const existingItem = req.session.cart.find(item => item.productId === product.id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                req.session.cart.push({
                    productId: product.id,
                    name: product.name,
                    price: product.price,
                    imageUrl: product.imageUrl,
                    category: product.category,
                    quantity: 1
                });
            }
        }
        res.redirect('/cart');
    } catch (err) {
        console.error(err);
        res.redirect('/');
    }
});

// Update Quantity
router.post('/update', (req, res) => {
    const { productId, action } = req.body;
    const item = req.session.cart.find(item => item.productId == productId);
    if (item) {
        if (action === 'increase') {
            item.quantity += 1;
        } else if (action === 'decrease' && item.quantity > 1) {
            item.quantity -= 1;
        }
    }
    res.redirect('/cart');
});

// Remove Item
router.post('/remove', (req, res) => {
    const { productId } = req.body;
    req.session.cart = req.session.cart.filter(item => item.productId != productId);
    res.redirect('/cart');
});

// Checkout Page (Auth required)
router.get('/checkout', (req, res) => {
    if (!req.session.user) {
        return res.redirect('/auth/login');
    }
    const cart = req.session.cart;
    if (cart.length === 0) {
        return res.redirect('/cart');
    }
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    res.render('cart/checkout', { title: 'Checkout', cart, total });
});

// Place Order
router.post('/place-order', async (req, res) => {
    if (!req.session.user) {
        return res.redirect('/auth/login');
    }

    const cart = req.session.cart;
    if (cart.length === 0) {
        return res.redirect('/cart');
    }

    try {
        const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const { address, city, state, zip } = req.body;

        const order = await Order.create({
            UserId: req.session.user.id,
            totalAmount,
            shippingAddress: `${address}, ${city}, ${state} ${zip}`,
            status: 'Pending',
            trackingId: 'SZ-' + Math.random().toString(36).substr(2, 9).toUpperCase()
        });

        for (const item of cart) {
            await OrderItem.create({
                OrderId: order.id,
                ProductId: item.productId,
                quantity: item.quantity,
                price: item.price
            });
        }

        // Clear cart
        req.session.cart = [];
        res.render('cart/confirmation', { title: 'Order Confirmed', order });

    } catch (err) {
        console.error(err);
        res.status(500).send('Error placing order');
    }
});

module.exports = router;
