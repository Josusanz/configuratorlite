import { reactive, readonly } from 'vue'

// Default mock data
const mockConfigurators = [
  {
    id: 'chair-001',
    name: 'Modern Office Chair',
    thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
    shortDescription: 'Ergonomic office chair with customizable features',
    basePrice: 299,
    isNew: true,
    views: [
      {
        id: 'front',
        name: 'Front',
        baseImage: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        thumbnail: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
      },
      {
        id: 'side',
        name: 'Side',
        baseImage: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        thumbnail: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
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
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'frame-premium',
        name: 'Premium Aluminum Frame',
        categoryId: 'frame',
        price: 50,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'seat-fabric',
        name: 'Fabric Seat',
        categoryId: 'seat',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'seat-leather',
        name: 'Leather Seat',
        categoryId: 'seat',
        price: 100,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
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
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
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
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
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
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'extras-headrest',
        name: 'Headrest',
        categoryId: 'extras',
        price: 30,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'extras-armrest',
        name: 'Adjustable Armrests',
        categoryId: 'extras',
        price: 45,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'extras-lumbar',
        name: 'Lumbar Support',
        categoryId: 'extras',
        price: 25,
        views: {
          front: 'https://images.pexels.com/photos/1957478/pexels-photo-1957478.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          side: 'https://images.pexels.com/photos/1957477/pexels-photo-1957477.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      }
    ]
  },
  {
    id: 'desk-001',
    name: 'Adjustable Standing Desk',
    thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
    shortDescription: 'Electric standing desk with customizable options',
    basePrice: 499,
    isNew: false,
    views: [
      {
        id: 'front',
        name: 'Front',
        baseImage: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        thumbnail: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
      },
      {
        id: 'top',
        name: 'Top',
        baseImage: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        thumbnail: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
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
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'frame-premium',
        name: 'Premium Frame',
        categoryId: 'frame',
        price: 100,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'top-laminate',
        name: 'Laminate',
        categoryId: 'top',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'top-bamboo',
        name: 'Bamboo',
        categoryId: 'top',
        price: 150,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'size-small',
        name: 'Small (48")',
        categoryId: 'size',
        price: 0,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'size-medium',
        name: 'Medium (60")',
        categoryId: 'size',
        price: 100,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'size-large',
        name: 'Large (72")',
        categoryId: 'size',
        price: 200,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'extras-cable',
        name: 'Cable Management',
        categoryId: 'extras',
        price: 50,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'extras-wireless',
        name: 'Wireless Charging',
        categoryId: 'extras',
        price: 80,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      },
      {
        id: 'extras-monitor',
        name: 'Monitor Arm',
        categoryId: 'extras',
        price: 120,
        views: {
          front: 'https://images.pexels.com/photos/3740896/pexels-photo-3740896.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
          top: 'https://images.pexels.com/photos/7241296/pexels-photo-7241296.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        }
      }
    ]
  }
]

// Create configurator state
const state = reactive({
  configurators: mockConfigurators,
  // Additional state properties can be added here
})

// Create configurator plugin
const ConfiguratorPlugin = {
  install(app) {
    // Provide state to the app
    app.provide('configurator', readonly(state))
    
    // Add global utility functions
    app.config.globalProperties.$configurator = {
      // Utility functions can be added here
      formatPrice: (price) => {
        return new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD'
        }).format(price)
      }
    }
  }
}

export default ConfiguratorPlugin