const { DataTypes } = require('sequelize');
const sequelize = require('./database');

const Order = sequelize.define('Order', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    totalAmount: {
        type: DataTypes.DECIMAL(10, 2),
        allowNull: false
    },
    status: {
        type: DataTypes.STRING,
        defaultValue: 'Pending' // Pending, Processing, Shipped, Delivered, Cancelled
    },
    shippingAddress: {
        type: DataTypes.TEXT,
        allowNull: false
    },
    city: {
        type: DataTypes.STRING,
        allowNull: true
    },
    state: {
        type: DataTypes.STRING,
        allowNull: true
    },
    zipCode: {
        type: DataTypes.STRING,
        allowNull: true
    },
    trackingId: {
        type: DataTypes.STRING,
        allowNull: true
    },
    paymentMethod: {
        type: DataTypes.STRING,
        defaultValue: 'COD'
    }
});

const OrderItem = sequelize.define('OrderItem', {
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    quantity: {
        type: DataTypes.INTEGER,
        allowNull: false,
        defaultValue: 1
    },
    price: {
        type: DataTypes.DECIMAL(10, 2),
        allowNull: false
    }
});

module.exports = { Order, OrderItem };
