// This file would normally connect to a database and provide API endpoints
// For this demo, we'll create a simple in-memory data store

const configurators = [
  {
    id: 'chair-001',
    name: 'Modern Office Chair',
    thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
    shortDescription: 'Ergonomic office chair with customizable features',
    description: 'Our premium office chair offers exceptional comfort and support for long work days. Customize every aspect to create your perfect seating solution.',
    basePrice: 299,
    isNew: true,
    views: [
      {
        id: 'front',
        name: 'Front',
        baseImage: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
        thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600'
      },
      {
        id: 'side',
        name: 'Side',
        baseImage: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600',
        thumbnail: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
      }
    ],
    categories: [
      { id: 'frame', name: 'Frame' },
      { id: 'seat', name: 'Seat Material' },
      { id: 'color', name: 'Color' },
      { id: 'extras', name: 'Extras' }
    ],
    layers: [
      {
        id: 'frame-standard',
        name: 'Standard Frame',
        categoryId: 'frame',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'frame-premium',
        name: 'Premium Aluminum Frame',
        categoryId: 'frame',
        price: 50,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'seat-fabric',
        name: 'Fabric Seat',
        categoryId: 'seat',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'seat-leather',
        name: 'Leather Seat',
        categoryId: 'seat',
        price: 100,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'color-black',
        name: 'Black',
        categoryId: 'color',
        type: 'color',
        color: '#000000',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'color-gray',
        name: 'Gray',
        categoryId: 'color',
        type: 'color',
        color: '#808080',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'color-blue',
        name: 'Blue',
        categoryId: 'color',
        type: 'color',
        color: '#0000FF',
        price: 20,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'extras-headrest',
        name: 'Headrest',
        categoryId: 'extras',
        price: 30,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'extras-armrest',
        name: 'Adjustable Armrests',
        categoryId: 'extras',
        price: 45,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'extras-lumbar',
        name: 'Lumbar Support',
        categoryId: 'extras',
        price: 25,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=600',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      }
    ]
  },
  {
    id: 'desk-001',
    name: 'Adjustable Standing Desk',
    thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
    shortDescription: 'Electric standing desk with customizable options',
    description: 'Transform your workspace with our premium adjustable standing desk. Choose from various desktop materials, sizes, and accessories to create your ideal workstation.',
    basePrice: 499,
    isNew: false,
    views: [
      {
        id: 'front',
        name: 'Front',
        baseImage: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
        thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600'
      },
      {
        id: 'top',
        name: 'Top',
        baseImage: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600',
        thumbnail: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
      }
    ],
    categories: [
      { id: 'frame', name: 'Frame' },
      { id: 'top', name: 'Desktop Surface' },
      { id: 'size', name: 'Size' },
      { id: 'extras', name: 'Extras' }
    ],
    layers: [
      {
        id: 'frame-standard',
        name: 'Standard Frame',
        categoryId: 'frame',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'frame-premium',
        name: 'Premium Frame',
        categoryId: 'frame',
        price: 100,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'top-laminate',
        name: 'Laminate',
        categoryId: 'top',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'top-bamboo',
        name: 'Bamboo',
        categoryId: 'top',
        price: 150,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'size-small',
        name: 'Small (48")',
        categoryId: 'size',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'size-medium',
        name: 'Medium (60")',
        categoryId: 'size',
        price: 100,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'size-large',
        name: 'Large (72")',
        categoryId: 'size',
        price: 200,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'extras-cable',
        name: 'Cable Management',
        categoryId: 'extras',
        price: 50,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'extras-wireless',
        name: 'Wireless Charging',
        categoryId: 'extras',
        price: 80,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      },
      {
        id: 'extras-monitor',
        name: 'Monitor Arm',
        categoryId: 'extras',
        price: 120,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=600',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=600'
        }
      }
    ]
  }
];

// Store for quotes
const quotes = [];

// API functions
export const getConfigurators = () => {
  return Promise.resolve(configurators);
};

export const getConfiguratorById = (id) => {
  const configurator = configurators.find(c => c.id === id);
  if (!configurator) {
    return Promise.reject(new Error('Configurator not found'));
  }
  return Promise.resolve(configurator);
};

export const submitQuote = (quoteData) => {
  const newQuote = {
    id: `quote-${Date.now()}`,
    timestamp: new Date().toISOString(),
    status: 'pending',
    ...quoteData
  };
  
  quotes.push(newQuote);
  return Promise.resolve(newQuote);
};

// Admin functions
export const createConfigurator = (configuratorData) => {
  const newConfigurator = {
    id: `config-${Date.now()}`,
    ...configuratorData
  };
  
  configurators.push(newConfigurator);
  return Promise.resolve(newConfigurator);
};

export const updateConfigurator = (id, configuratorData) => {
  const index = configurators.findIndex(c => c.id === id);
  if (index === -1) {
    return Promise.reject(new Error('Configurator not found'));
  }
  
  configurators[index] = {
    ...configurators[index],
    ...configuratorData
  };
  
  return Promise.resolve(configurators[index]);
};

export const deleteConfigurator = (id) => {
  const index = configurators.findIndex(c => c.id === id);
  if (index === -1) {
    return Promise.reject(new Error('Configurator not found'));
  }
  
  configurators.splice(index, 1);
  return Promise.resolve({ success: true });
};

export const getQuotes = () => {
  return Promise.resolve(quotes);
};

export const updateQuoteStatus = (id, status) => {
  const quote = quotes.find(q => q.id === id);
  if (!quote) {
    return Promise.reject(new Error('Quote not found'));
  }
  
  quote.status = status;
  return Promise.resolve(quote);
};