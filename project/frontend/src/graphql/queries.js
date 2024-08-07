export const GET_USERS = `
  query {
    users {
      id
      name
      email
      profile {
        bio
        avatar
      }
      posts {
        title
        content
      }
    }
  }
`;

export const GET_USER_BASIC_INFO = `
  query {
    users {
      id
      name
      email
    }
  }
`;

export const GET_USER_PROFILE = `
  query {
    users {
      id
      profile {
        bio
        avatar
      }
    }
  }
`;

export const GET_USER_POSTS = `
  query {
    users {
      id
      posts {
        title
        content
      }
    }
  }
`;
