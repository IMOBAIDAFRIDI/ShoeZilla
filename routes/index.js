const express = require('express');
const router = express.Router();
const Product = require('../models/Product');
const { Op } = require('sequelize');

// Home Page
router.get('/', async (req, res) => {
    try {
        const products = await Product.findAll({
            where: { isFeatured: true }, // Assuming we want featured products on home
            limit: 4
        });
        res.render('home/index', { title: 'ShoeZilla - Home', products });
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Category Page
router.get('/category/:category', async (req, res) => {
    try {
        const category = req.params.category;
        const products = await Product.findAll({
            where: { category: category }
        });
        res.render('home/category', { title: `ShoeZilla - ${category}`, products, category });
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Product Details
router.get('/product/:id', async (req, res) => {
    try {
        const product = await Product.findByPk(req.params.id);
        if (!product) {
            return res.status(404).send('Product not found');
        }
        res.render('home/details', { title: product.name, product });
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Search
router.get('/search', async (req, res) => {
    try {
        const query = req.query.query;
        const products = await Product.findAll({
            where: {
                name: { [Op.like]: `%${query}%` }
            }
        });
        res.render('home/search', { title: `Search Results for "${query}"`, products, query });
    } catch (err) {
        console.error(err);
        res.status(500).send('Server Error');
    }
});

// Static pages
router.get('/contact', (req, res) => res.render('home/contact', { title: 'Contact Us' }));
router.get('/faq', (req, res) => res.render('home/faq', { title: 'FAQ' }));

module.exports = router;
