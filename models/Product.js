const { DataTypes } = require('sequelize');
const sequelize = require('./database');

const Product = sequelize.define('Product', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    name: {
        type: DataTypes.STRING,
        allowNull: false
    },
    description: {
        type: DataTypes.TEXT,
        allowNull: true
    },
    price: {
        type: DataTypes.DECIMAL(10, 2),
        allowNull: false
    },
    oldPrice: {
        type: DataTypes.DECIMAL(10, 2),
        allowNull: true
    },
    imageUrl: {
        type: DataTypes.STRING,
        allowNull: true
    },
    category: {
        type: DataTypes.STRING,
        allowNull: false
    },
    stock: {
        type: DataTypes.INTEGER,
        defaultValue: 0
    },
    isFeatured: {
        type: DataTypes.BOOLEAN,
        defaultValue: false
    }
});

module.exports = Product;
