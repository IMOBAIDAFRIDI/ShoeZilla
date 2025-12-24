const express = require('express');
const router = express.Router();
const Product = require('../models/Product');
const User = require('../models/User');
const { Order } = require('../models/Order');

// Middleware to check if user is admin
const isAdmin = (req, res, next) => {
    if (req.session.user && req.session.user.isAdmin) {
        return next();
    }
    res.redirect('/auth/login');
};

router.use(isAdmin);

router.get('/', async (req, res) => {
    // Dashboard stats
    const productCount = await Product.count();
    const userCount = await User.count();
    const orderCount = await Order.count();

    res.render('admin/dashboard', {
        title: 'Admin Dashboard',
        stats: { products: productCount, users: userCount, orders: orderCount }
    });
});

// Product Management Routes

// List Products
router.get('/products', async (req, res) => {
    try {
        const products = await Product.findAll();
        res.render('admin/products_list', { title: 'Manage Products', products });
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Create Product Form
router.get('/products/create', (req, res) => {
    res.render('admin/product_form', { title: 'Create Product', product: null });
});

// Create Product Action
router.post('/products/create', async (req, res) => {
    try {
        const { name, category, price, oldPrice, imageUrl, description, stock, isFeatured } = req.body;
        await Product.create({
            name,
            category,
            price,
            oldPrice: oldPrice || null,
            imageUrl,
            description,
            stock,
            isFeatured: isFeatured === 'true'
        });
        res.redirect('/admin/products');
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Edit Product Form
router.get('/products/edit/:id', async (req, res) => {
    try {
        const product = await Product.findByPk(req.params.id);
        if (!product) {
            return res.status(404).send('Product not found');
        }
        res.render('admin/product_form', { title: 'Edit Product', product });
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Edit Product Action
router.post('/products/edit/:id', async (req, res) => {
    try {
        const { name, category, price, oldPrice, imageUrl, description, stock, isFeatured } = req.body;
        const product = await Product.findByPk(req.params.id);
        if (!product) {
            return res.status(404).send('Product not found');
        }

        await product.update({
            name,
            category,
            price,
            oldPrice: oldPrice || null,
            imageUrl,
            description,
            stock,
            isFeatured: isFeatured === 'true'
        });

        res.redirect('/admin/products');
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Delete Product
router.post('/products/delete/:id', async (req, res) => {
    try {
        const product = await Product.findByPk(req.params.id);
        if (product) {
            await product.destroy();
        }
        res.redirect('/admin/products');
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

module.exports = router;

