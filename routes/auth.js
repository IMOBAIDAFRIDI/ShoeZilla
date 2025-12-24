const express = require('express');
const router = express.Router();
const User = require('../models/User');
const bcrypt = require('bcrypt');

router.get('/login', (req, res) => {
    res.render('auth/login', { title: 'Login', error: null });
});

router.post('/login', async (req, res) => {
    const { email, password } = req.body;
    try {
        const user = await User.findOne({ where: { email } });
        if (user && await user.checkPassword(password)) {
            req.session.user = user;
            return res.redirect('/');
        }
        res.render('auth/login', { title: 'Login', error: 'Invalid email or password' });
    } catch (err) {
        console.error(err);
        res.render('auth/login', { title: 'Login', error: 'An error occurred' });
    }
});

router.get('/register', (req, res) => {
    res.render('auth/register', { title: 'Register', error: null });
});

router.post('/register', async (req, res) => {
    const { username, email, password } = req.body;
    try {
        // Check if user exists
        const existing = await User.findOne({ where: { email } });
        if (existing) {
            return res.render('auth/register', { title: 'Register', error: 'Email already registered' });
        }

        await User.create({ username, email, password });
        res.redirect('/auth/login');
    } catch (err) {
        console.error(err);
        res.render('auth/register', { title: 'Register', error: 'An error occurred' });
    }
});

router.get('/logout', (req, res) => {
    req.session.destroy();
    res.redirect('/');
});

module.exports = router;
