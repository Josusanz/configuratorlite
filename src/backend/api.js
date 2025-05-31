import { 
  getConfigurators, 
  getConfiguratorById, 
  submitQuote,
  createConfigurator,
  updateConfigurator,
  deleteConfigurator,
  getQuotes,
  updateQuoteStatus
} from './index';

// Simulate API delay
const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

// API endpoints
export const fetchConfigurators = async () => {
  await delay(500); // Simulate network delay
  return getConfigurators();
};

export const fetchConfiguratorById = async (id) => {
  await delay(300);
  return getConfiguratorById(id);
};

export const sendQuoteRequest = async (quoteData) => {
  await delay(1000);
  return submitQuote(quoteData);
};

// Admin API endpoints
export const adminFetchConfigurators = async () => {
  await delay(500);
  return getConfigurators();
};

export const adminFetchQuotes = async () => {
  await delay(500);
  return getQuotes();
};

export const adminCreateConfigurator = async (configuratorData) => {
  await delay(800);
  return createConfigurator(configuratorData);
};

export const adminUpdateConfigurator = async (id, configuratorData) => {
  await delay(800);
  return updateConfigurator(id, configuratorData);
};

export const adminDeleteConfigurator = async (id) => {
  await delay(800);
  return deleteConfigurator(id);
};

export const adminUpdateQuoteStatus = async (id, status) => {
  await delay(500);
  return updateQuoteStatus(id, status);
};